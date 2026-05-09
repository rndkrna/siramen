<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    protected string $model   = 'gemini-2.0-flash';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    /**
     * Kirim prompt ke Gemini dan parsing respons sebagai JSON.
     * Prompt HARUS meminta output JSON murni.
     */
    public function generateContent(string $prompt): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('GeminiService: GEMINI_API_KEY tidak terset di .env');
            return null;
        }

        try {
            $response = Http::timeout(60)->post(
                $this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.4,
                        'topK'            => 32,
                        'topP'            => 1,
                        'maxOutputTokens' => 4096,
                        // responseMimeType hanya tersedia di model tertentu,
                        // kita parse manual agar kompatibel dengan semua model
                    ],
                ]
            );

            if (!$response->successful()) {
                Log::error('Gemini API Error (' . $response->status() . '): ' . $response->body());
                return null;
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                Log::error('Gemini API: respons kosong.', ['data' => $data]);
                return null;
            }

            // Bersihkan markdown code block kalau ada (```json ... ```)
            $text = preg_replace('/^```(?:json)?\s*/i', '', trim($text));
            $text = preg_replace('/\s*```$/i', '', $text);

            $decoded = json_decode(trim($text), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini: JSON decode gagal. Raw text: ' . $text);
                return null;
            }

            return $decoded;

        } catch (\Exception $e) {
            Log::error('GeminiService Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate ringkasan dokumen.
     */
    public function generateSummary(string $content): ?array
    {
        $prompt = <<<PROMPT
Buat ringkasan dari konten dokumen berikut dalam format JSON MURNI (tanpa markdown, tanpa komentar).
Struktur JSON harus persis seperti ini:
{
  "content_md": "Ringkasan singkat dalam format Markdown",
  "key_points": ["poin 1", "poin 2", "poin 3"],
  "possible_questions": ["Pertanyaan 1?", "Pertanyaan 2?"],
  "language": "id"
}

Konten dokumen:
{$content}
PROMPT;

        return $this->generateContent($prompt);
    }
}
