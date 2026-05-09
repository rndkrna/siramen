<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua quiz milik user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $quizzes = Quiz::where('user_id', $user->id)
            ->when($request->document_id, fn($q) => $q->where('document_id', $request->document_id))
            ->with('document')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($quizzes);
    }

    /**
     * Generate quiz baru dari dokumen menggunakan AI Gemini.
     */
    public function generate(string $documentId): JsonResponse
    {
        $user    = $this->getCurrentUser();
        $document = Document::findOrFail($documentId);

        // Ambil teks ringkasan jika ada, atau gunakan nama file sebagai konteks
        $context = $document->summary
            ? $document->summary->content_md
            : "Dokumen berjudul: {$document->file_name}";

        $prompt = "Buatkan 5 soal pilihan ganda (multiple choice) dari konten berikut.
Return dalam format JSON array seperti ini, TANPA teks lain apapun:
[
  {
    \"question_text\": \"...\",
    \"option_a\": \"...\",
    \"option_b\": \"...\",
    \"option_c\": \"...\",
    \"option_d\": \"...\",
    \"correct_answer\": \"a\",
    \"explanation\": \"...\"
  }
]

Konten:
{$context}";

        $questions = $this->gemini->generateContent($prompt);

        if (!$questions || !is_array($questions)) {
            return response()->json(['message' => 'Gagal generate quiz dari AI.'], 500);
        }

        // Simpan quiz
        $quiz = Quiz::create([
            'user_id'         => $user->id,
            'document_id'     => $documentId,
            'title'           => 'Quiz: ' . $document->file_name,
            'total_questions' => count($questions),
        ]);

        // Simpan setiap pertanyaan
        foreach ($questions as $q) {
            QuizQuestion::create([
                'quiz_id'        => $quiz->id,
                'question_text'  => $q['question_text'] ?? '',
                'option_a'       => $q['option_a'] ?? '',
                'option_b'       => $q['option_b'] ?? '',
                'option_c'       => $q['option_c'] ?? '',
                'option_d'       => $q['option_d'] ?? '',
                'correct_answer' => $q['correct_answer'] ?? 'a',
                'explanation'    => $q['explanation'] ?? '',
            ]);
        }

        return response()->json([
            'message' => 'Quiz berhasil dibuat.',
            'data'    => $quiz->load('questions'),
        ], 201);
    }

    /**
     * Detail quiz dengan soal-soalnya (correct_answer disembunyikan).
     */
    public function show(string $id): JsonResponse
    {
        $quiz = Quiz::with(['questions' => function ($q) {
            // Sembunyikan correct_answer & explanation saat tampil soal
            $q->select('id', 'quiz_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d');
        }])->findOrFail($id);

        return response()->json($quiz);
    }

    /**
     * Hapus quiz beserta semua soal dan attempt-nya.
     */
    public function destroy(string $id): JsonResponse
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->questions()->delete();
        $quiz->attempts()->delete();
        $quiz->delete();

        return response()->json(['message' => 'Quiz berhasil dihapus.']);
    }
}
