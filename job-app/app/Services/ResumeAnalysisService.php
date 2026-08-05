<?php

namespace App\Services;

use App\Models\Resume;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Smalot\PdfParser\Parser;

class ResumeAnalysisService
{
    /**
     * Extract structured information from a resume.
     */
    public function extractResumeInformation(Resume $resume): array
    {
        dd($resume);

        $fileUrl = Storage::disk('s3')->url($resume->fileUri);

        $rawText = $this->extractTextFromPdf($fileUrl);

        Log::info('Resume text extracted successfully.', [
            'resume_id' => $resume->id,
            'length' => strlen($rawText),
        ]);

        $response = OpenAI::chat()->create([
            'model' => 'openai/gpt-oss-20b:free',

            'messages' => [

                [
                    'role' => 'system',
                    'content' => <<<PROMPT
You are an expert resume parser.

Extract the information from the resume and return ONLY valid JSON.

Return exactly this format:

{
    "summary": "...",
    "skills": [],
    "experience": [],
    "education": []
}

Rules:

- Do not include markdown.
- Do not include explanations.
- Do not include ```json.
- Return JSON only.
PROMPT
                ],

                [
                    'role' => 'user',
                    'content' => $rawText,
                ],

            ],
        ]);

        $content = trim($response->choices[0]->message->content);

        $analysis = json_decode($content, true);

        if (!is_array($analysis)) {

            Log::error('Failed to decode AI response.', [
                'response' => $content,
            ]);

            throw new \RuntimeException('Invalid AI response.');
        }

        return [
            'summary' => $analysis['summary'] ?? '',
            'skills' => $analysis['skills'] ?? [],
            'experience' => $analysis['experience'] ?? [],
            'education' => $analysis['education'] ?? [],
            'raw_text' => $rawText,
        ];
    }

    /**
     * Extract plain text from a PDF file stored on S3.
     */
    private function extractTextFromPdf(string $fileUrl): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'resume_');

        $filePath = parse_url($fileUrl, PHP_URL_PATH);

        if (!$filePath) {
            throw new \RuntimeException('Invalid file URL.');
        }

        $filename = basename($filePath);

        $storagePath = "resumes/{$filename}";

        if (!Storage::disk('s3')->exists($storagePath)) {
            throw new \RuntimeException('Resume file not found.');
        }

        $pdfContent = Storage::disk('s3')->get($storagePath);

        if (!$pdfContent) {
            throw new \RuntimeException('Failed to read resume file.');
        }

        file_put_contents($tempFile, $pdfContent);

        try {

            $parser = new Parser();

            $pdf = $parser->parseFile($tempFile);

            return trim($pdf->getText());

        } finally {

            if (file_exists($tempFile)) {
                unlink($tempFile);
            }

        }
    }
}
