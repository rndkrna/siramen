<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Services\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class ProcessQuizAI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle(GeminiService $gemini)
    {
        try {
            $text = $this->extractText();
            if (empty($text)) return;

            // Truncate to avoid quota limits (6000 characters for quiz)
            $truncatedText = mb_substr($text, 0, 6000);

            $prompt = "Buatlah 5 soal pilihan ganda berdasarkan materi berikut. Berikan output dalam format JSON array yang berisi objek dengan key: question, options (array isi 4 string), dan correct_answer (index 0-3).\n\nMATERI:\n" . $truncatedText;

            $result = $gemini->generateContent($prompt);

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $rawJson = $result['candidates'][0]['content']['parts'][0]['text'];
                $jsonStr = preg_replace('/```json\n?|\n?```/', '', $rawJson);
                $questionsData = json_decode(trim($jsonStr), true);

                if (is_array($questionsData)) {
                    $quiz = Quiz::create([
                        'user_id' => $this->document->user_id,
                        'document_id' => $this->document->id,
                        'title' => 'Kuis: ' . $this->document->file_name,
                        'total_questions' => count($questionsData),
                    ]);

                    foreach ($questionsData as $q) {
                        QuizQuestion::create([
                            'quiz_id' => $quiz->id,
                            'question_text' => $q['question'],
                            'options' => $q['options'],
                            'correct_answer' => $q['correct_answer'],
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Quiz Generation Failed: " . $e->getMessage());
        }
    }

    private function extractText()
    {
        $path = storage_path('app/public/' . str_replace('/storage/', '', $this->document->file_url));
        if (!file_exists($path)) return '';

        $extension = pathinfo($this->document->file_name, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($path);
                return $pdf->getText();
            } catch (\Exception $e) {
                return '';
            }
        } elseif ($extension === 'docx') {
            try {
                $phpWord = IOFactory::load($path);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        $text .= $this->getPhpWordElementText($element);
                    }
                }
                return $text;
            } catch (\Exception $e) {
                return '';
            }
        } else {
            return file_get_contents($path);
        }
    }

    private function getPhpWordElementText($element)
    {
        $text = '';
        if (method_exists($element, 'getText')) {
            $text .= $element->getText() . "\n";
        } elseif (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $childElement) {
                $text .= $this->getPhpWordElementText($childElement);
            }
        }
        return $text;
    }
}
