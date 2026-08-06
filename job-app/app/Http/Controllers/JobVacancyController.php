<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use App\Services\ResumeMatchingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

class JobVacancyController extends Controller
{
   public function __construct(
    private ResumeAnalysisService $resumeAnalysisService,
    private ResumeMatchingService $resumeMatchingService,
) {
}

    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        $resumes = Resume::where('userId', auth()->id())
            ->latest()
            ->get()
            ->map(function ($resume) {

                $resume->viewUrl = Storage::disk('s3')->temporaryUrl(
                    $resume->fileUri,
                    now()->addMinutes(10)
                );

                return $resume;
            });

        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
{
    $jobVacancy = JobVacancy::findOrFail($id);

    try {

            $resume = null;
            $jobApplication = null;

        DB::transaction(function () use (
    $request,
    $jobVacancy,
    &$resume,
    &$jobApplication
) {

            $alreadyApplied = JobApplication::where('jobVacancyId', $jobVacancy->id)
                ->where('userId', auth()->id())
                ->lockForUpdate()
                ->exists();

            if ($alreadyApplied) {
                throw new \RuntimeException('ALREADY_APPLIED');
            }

            if ($request->resume_option === 'existing') {

                $resume = Resume::where('id', $request->resume_id)
                    ->where('userId', auth()->id())
                    ->firstOrFail();

            } else {

                $file = $request->file('resume_file');

                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('resumes', $filename, 's3');

                if (! $path) {
                    throw new \RuntimeException('UPLOAD_FAILED');
                }

                $resume = Resume::create([
                    'fileName' => $file->getClientOriginalName(),
                    'fileUri' => $path,
                    'userId' => auth()->id(),

                    'contactDetails' => [
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                    ],

                    'summary' => '',
                    'skills' => [],
                    'experience' => [],
                    'education' => [],
                ]);
            }

                $jobApplication = JobApplication::create([
                    'status' => 'pending',
                    'jobVacancyId' => $jobVacancy->id,
                    'userId' => auth()->id(),
                    'resumeId' => $resume->id,
                    'aiGeneratedScore' => 0,
                    'aiGeneratedFeedback' => '',
                ]);
        });

        if ($resume && $resume->fileUri) {
            try {

                if (empty($resume->summary)) {

                        $analysis = $this->resumeAnalysisService
                            ->extractResumeInformation($resume);

                        $resume->update([
                            'summary' => $analysis['summary'],
                            'skills' => $analysis['skills'],
                            'experience' => $analysis['experience'],
                            'education' => $analysis['education'],
                        ]);

                        $resume->refresh();
                    }


                    $matching = $this->resumeMatchingService
                        ->analyze($resume, $jobVacancy);

                    if ($jobApplication) {
                        $jobApplication->update([
                            'aiGeneratedScore' => $matching['score'],
                            'aiGeneratedFeedback' => $matching['feedback'],
                        ]);
                    }


            } catch (\Throwable $e) {

                    logger()->error('Resume analysis or matching failed.', [
                        'resume_id' => $resume->id,
                        'job_application_id' => $jobApplication?->id,
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);

    if ($jobApplication) {
                        $jobApplication->update([
                            'aiGeneratedScore' => 0,
                            'aiGeneratedFeedback' => 'AI analysis is temporarily unavailable. Please try again later.',
                        ]);
                    }

                }

        }

    } catch (\RuntimeException $e) {

        return match ($e->getMessage()) {

            'ALREADY_APPLIED' => redirect()
                ->route('job-applications.index')
                ->with('info', 'You have already applied for this job.'),

            'UPLOAD_FAILED' => back()
                ->withInput()
                ->with('error', 'Failed to upload your resume. Please try again.'),

            default => throw $e,
        };
    }

    return redirect()
        ->route('job-applications.index')
        ->with('success', 'Your application has been submitted successfully.');
}

    public function testOpenRouter()
    {
        abort_unless(app()->environment('local'), 404);

        $response = OpenAI::chat()->create([
            'model' => 'openai/gpt-oss-20b:free',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant specialized in career guidance.',
                ],
                [
                    'role' => 'user',
                    'content' => 'I am a Computer Science student specializing in Cybersecurity. I know Laravel, React, MySQL, Docker, and Git. Which backend skill should I learn next and why? Answer in less than 150 words.',
                ],
            ],
        ]);

        return response()->json([
            'success' => true,
            'question' => 'Which backend skill should I learn next?',
            'reply' => $response->choices[0]->message->content,
        ]);
    }

    public function testStorage()
    {
        abort_unless(app()->environment('local'), 404);

        Storage::disk('s3')->put(
            'test.txt',
            'Hello from Laravel + Supabase Storage!'
        );

        return 'File uploaded successfully!';
    }
}
