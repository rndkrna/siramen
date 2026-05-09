<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua attempt milik user pada quiz tertentu.
     */
    public function index(string $quizId): JsonResponse
    {
        $user = $this->getCurrentUser();

        $attempts = QuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->orderByDesc('attempted_at')
            ->get();

        return response()->json($attempts);
    }

    /**
     * Submit jawaban quiz — hitung skor dan simpan attempt.
     */
    public function store(Request $request, string $quizId): JsonResponse
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'answers'          => 'required|array',
            'answers.*.question_id' => 'required|string|exists:quiz_questions,id',
            'answers.*.answer'      => 'required|string|in:a,b,c,d',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        $quiz      = Quiz::with('questions')->findOrFail($quizId);
        $questions = $quiz->questions->keyBy('id');

        $correctCount = 0;
        $answersResult = [];

        foreach ($validated['answers'] as $ans) {
            $question = $questions->get($ans['question_id']);
            $isCorrect = $question && strtolower($ans['answer']) === strtolower($question->correct_answer);

            if ($isCorrect) {
                $correctCount++;
            }

            $answersResult[] = [
                'question_id'    => $ans['question_id'],
                'your_answer'    => $ans['answer'],
                'correct_answer' => $question?->correct_answer,
                'is_correct'     => $isCorrect,
            ];
        }

        $totalQuestions = $quiz->total_questions ?: count($validated['answers']);
        $score          = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;

        $attempt = QuizAttempt::create([
            'quiz_id'          => $quizId,
            'user_id'          => $user->id,
            'score'            => $score,
            'duration_seconds' => $validated['duration_seconds'] ?? 0,
            'answers_json'     => $answersResult,
            'attempted_at'     => now(),
        ]);

        return response()->json([
            'message'       => 'Quiz berhasil dikumpulkan.',
            'score'         => $score,
            'correct'       => $correctCount,
            'total'         => $totalQuestions,
            'answers'       => $answersResult,
            'attempt_id'    => $attempt->id,
        ], 201);
    }

    /**
     * Detail satu attempt lengkap dengan jawaban benar.
     */
    public function show(string $quizId, string $attemptId): JsonResponse
    {
        $attempt = QuizAttempt::where('quiz_id', $quizId)
            ->findOrFail($attemptId);

        // Sertakan soal lengkap dengan jawaban benar untuk review
        $questions = QuizQuestion::where('quiz_id', $quizId)->get();

        return response()->json([
            'attempt'   => $attempt,
            'questions' => $questions,
        ]);
    }
}
