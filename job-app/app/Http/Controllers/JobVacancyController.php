<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;


class JobVacancyController extends Controller
{
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.apply', compact('jobVacancy'));
    }
    public function processApplication(Request $request, string $id)
    {
    }


// public function testOpenRouter()


public function testOpenRouter()
{
    $response = OpenAI::chat()->create([
        'model' => 'openai/gpt-oss-20b:free',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a helpful assistant specialized in career guidance.'
            ],
            [
                'role' => 'user',
                'content' => 'I am a Computer Science student specializing in Cybersecurity. I know Laravel, React, MySQL, Docker, and Git. Which backend skill should I learn next and why? Answer in less than 150 words.'
            ],
        ],
    ]);

    return response()->json([
        'success' => true,
        'question' => 'Which backend skill should I learn next?',
        'reply' => $response->choices[0]->message->content,
    ]);
}
// {
//     $response = OpenAI::chat()->create([
//         'model' => 'openai/gpt-oss-20b:free',
//         'messages' => [
//             [
//                 'role' => 'user',
//                 'content' => 'Introduce yourself in one short sentence.'
//             ],
//         ],
//     ]);

//     return response()->json([
//         'success' => true,
//         'reply' => $response->choices[0]->message->content,
//     ]);
// }


public function testStorage()
{
    Storage::disk('s3')->put(
        'test.txt',
        'Hello from Laravel + Supabase Storage!'
    );

    return 'File uploaded successfully!';
}


}
