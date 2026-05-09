<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDocumentAI;
use App\Jobs\ProcessQuizAI;
use App\Models\Document;
use App\Models\Subject;
use App\Models\User;
use App\Models\Summary;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class DocumentController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    public function create()
    {
        $user     = $this->getCurrentUser();
        $subjects = Subject::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        return view('documents.create', compact('subjects'));
    }

    public function templates()
    {
        return view('documents.templates');
    }

    public function index()
    {
        $user      = $this->getCurrentUser();
        $documents = Document::where('user_id', $user->id)
            ->with(['subject', 'summary'])
            ->orderByDesc('uploaded_at')
            ->get();

        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $user = $this->getCurrentUser();

        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,txt|max:10240',
            'subject_id' => 'required|exists:subjects,id',
            'is_lab' => 'nullable|boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents/' . $user->id, 'public');

        $document = Document::create([
            'user_id' => $user->id,
            'subject_id' => $request->subject_id,
            'file_name' => $file->getClientOriginalName(),
            'file_url' => Storage::url($path),
            'mime_type' => $file->getMimeType(),
            'file_size_kb' => round($file->getSize() / 1024),
            'status' => 'pending',
            'is_lab' => $request->has('is_lab'),
            'uploaded_at' => now(),
        ]);

        return redirect()->route('documents.show', $document)->with('success', 'Document uploaded successfully!');
    }

    public function show(Document $document)
    {
        $document->load(['subject', 'summary', 'quizzes']);
        return view('documents.show', compact('document'));
    }

    public function generateSummary(Document $document)
    {
        $document->update(['status' => 'processing']);
        ProcessDocumentAI::dispatch($document);
        
        return back()->with('success', 'Materi sedang diringkas oleh AI di latar belakang. Silakan tunggu sebentar.');
    }

    public function generateQuiz(Document $document)
    {
        ProcessQuizAI::dispatch($document);
        
        return back()->with('success', 'Soal kuis sedang dibuat oleh AI. Cek halaman Generator Soal dalam beberapa saat.');
    }

    private function extractTextFromFile(Document $document)
    {
        $filePath = storage_path('app/public/' . str_replace('/storage/', '', $document->file_url));

        if (!file_exists($filePath)) {
            return null;
        }

        try {
            if ($document->mime_type === 'application/pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($filePath);
                return $pdf->getText();
            } elseif ($document->mime_type === 'text/plain') {
                return file_get_contents($filePath);
            } elseif ($document->mime_type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        $text .= $this->getPhpWordElementText($element);
                    }
                }
                return $text;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Extraction Error: ' . $e->getMessage());
            return null;
        }

        return "Konten file: " . $document->file_name;
    }

    private function getPhpWordElementText($element)
    {
        $text = '';
        if (method_exists($element, 'getText')) {
            $elementText = $element->getText();
            if (is_string($elementText)) {
                $text .= $elementText . "\n";
            } elseif ($elementText instanceof \PhpOffice\PhpWord\Element\TextRun) {
                foreach ($elementText->getElements() as $childElement) {
                    $text .= $this->getPhpWordElementText($childElement);
                }
            }
        } elseif (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $childElement) {
                $text .= $this->getPhpWordElementText($childElement);
            }
        }
        return $text;
    }

    public function destroy(Document $document)
    {
        $path = str_replace('/storage/', '', $document->file_url);
        Storage::disk('public')->delete($path);
        
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted.');
    }
}
