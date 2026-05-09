<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\Summary;
use App\Services\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class ProcessDocumentAI implements ShouldQueue
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
            $this->document->update(['status' => 'processing']);

            $text = $this->extractText();
            if (empty($text)) {
                $this->document->update(['status' => 'failed']);
                return;
            }

            // Truncate to avoid quota limits (8000 characters for summary)
            $truncatedText = mb_substr($text, 0, 8000);

            $prompt = "Ringkaslah materi akademik berikut dengan poin-poin penting, penjelasan singkat, dan kesimpulan. Gunakan format Markdown yang rapi.\n\nMATERI:\n" . $truncatedText;

            $result = $gemini->generateContent($prompt);

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $summaryContent = $result['candidates'][0]['content']['parts'][0]['text'];

                Summary::updateOrCreate(
                    ['document_id' => $this->document->id],
                    [
                        'user_id' => $this->document->user_id,
                        'content_md' => $summaryContent,
                    ]
                );

                $this->document->update(['status' => 'processed']);
            } else {
                $this->document->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            \Log::error("AI Processing Failed: " . $e->getMessage());
            $this->document->update(['status' => 'failed']);
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
