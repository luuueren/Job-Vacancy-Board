<?php

namespace App\Services;

use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ResumeMatchingService
{
    /**
     * Compare a resume with a job vacancy using AI.
     */
    public function analyze(
        Resume $resume,
        JobVacancy $jobVacancy
    ): array {

        $resumeData = [
            'summary' => $resume->summary,
            'skills' => $resume->skills,
            'experience' => $resume->experience,
            'education' => $resume->education,
        ];

        $jobData = [
            'title' => $jobVacancy->title,
            'description' => $jobVacancy->description,
            'type' => $jobVacancy->type,
            'location' => $jobVacancy->location,
        ];

        $response = OpenAI::chat()->create([

            'model' => 'openai/gpt-oss-20b:free',

            'messages' => [

                [
                    'role' => 'system',
                    'content' => <<<PROMPT
You are an expert technical recruiter.

Compare the candidate resume with the job vacancy.

Return ONLY valid JSON.

Example:

{
    "score": 85,
    "feedback": "Excellent Laravel and React experience. Candidate should improve Docker and AWS knowledge."
}

Rules:

- score must be an integer between 0 and 100.
- feedback must be less than 120 words.
- Do not include markdown.
- Do not include explanations.
- Do not wrap the JSON inside ```json.
- Return JSON only.
PROMPT
                ],

                [
                    'role' => 'user',
                    'content' => json_encode([
                        'job' => $jobData,
                        'resume' => $resumeData,
                    ]),
                ],

            ],

        ]);

        $content = trim(
            $response->choices[0]->message->content
        );

        // Remove markdown if the model returns ```json
        $content = preg_replace('/^```json|```$/m', '', $content);
        $content = trim($content);

        $analysis = json_decode($content, true);

        if (! is_array($analysis)) {

            Log::error('Failed to decode AI matching response.', [
                'response' => $content,
            ]);

            throw new \RuntimeException(
                'Invalid AI response.'
            );
        }

        return [

            'score' => max(
                0,
                min(
                    100,
                    (int) ($analysis['score'] ?? 0)
                )
            ),

            'feedback' => trim(
                $analysis['feedback'] ?? ''
            ),

        ];
    }
}
