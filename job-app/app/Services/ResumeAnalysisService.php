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
     * الحد الأقصى لعدد الأحرف المُرسلة إلى النموذج
     * (لتفادي تجاوز حد الـ tokens في السير الذاتية الطويلة جدًا).
     */
    private const MAX_TEXT_LENGTH = 15000;

    /**
     * Extract structured information from a resume.
     */
    public function extractResumeInformation(Resume $resume): array
    {
        $storagePath = $resume->fileUri;

        $rawText = $this->extractTextFromPdf($storagePath);
        // dd($rawText);

        Log::info('Resume text extracted successfully.', [
            'resume_id' => $resume->id,
            'length' => strlen($rawText),
        ]);


        if (trim($rawText) === '') {
            throw new \RuntimeException('No extractable text found in resume PDF.');
        }

        $cleanText = $this->sanitizeText($rawText);

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
                    'content' => $cleanText,
                ],

            ],
        ]);

        $content = trim($response->choices[0]->message->content);

        $analysis = json_decode($content, true);

        if (! is_array($analysis)) {

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
    private function extractTextFromPdf(string $storagePath): string
    {
        if (! Storage::disk('s3')->exists($storagePath)) {
            throw new \RuntimeException('Resume file not found.');
        }

        try {
            $pdfContent = Storage::disk('s3')->get($storagePath);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to read resume file: ' . $e->getMessage());
        }

        if ($pdfContent === null || $pdfContent === false || $pdfContent === '') {
            throw new \RuntimeException('Failed to read resume file.');
        }


        $tempFile = tempnam(sys_get_temp_dir(), 'resume_');
        $tempFilePdf = $tempFile . '.pdf';
        rename($tempFile, $tempFilePdf);

        file_put_contents($tempFilePdf, $pdfContent);

        try {

            $parser = new Parser();

            $pdf = $parser->parseFile($tempFilePdf);

            return trim($pdf->getText());

        } catch (\Throwable $e) {

            throw new \RuntimeException('Failed to parse resume PDF: ' . $e->getMessage());

        } finally {

            if (file_exists($tempFilePdf)) {
                unlink($tempFilePdf);
            }

        }
    }


    private function sanitizeText(string $text): string
    {
        $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $text);

        if ($clean === false) {
            $clean = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        }

        if (mb_strlen($clean) > self::MAX_TEXT_LENGTH) {
            $clean = mb_substr($clean, 0, self::MAX_TEXT_LENGTH);
        }

        return $clean;
    }
}
