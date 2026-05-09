<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    public function index()
    {
        $user    = $this->getCurrentUser();
        $quizzes = Quiz::where('user_id', $user->id)
            ->with(['document'])
            ->orderByDesc('created_at')
            ->get();

        $attempts = \App\Models\QuizAttempt::where('user_id', $user->id)->get();
        $avgScore = $attempts->avg('score') ?? 0;
        $totalCompleted = $attempts->count();

        return view('quizzes.index', compact('quizzes', 'avgScore', 'totalCompleted'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $user    = $this->getCurrentUser();
        $answers = $request->input('answers', []);
        $correct = 0;
        $total   = $quiz->total_questions;

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && (int)$answers[$question->id] === (int)$question->correct_answer) {
                $correct++;
            }
        }

        $score = ($total > 0) ? ($correct / $total) * 100 : 0;

        \App\Models\QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score'   => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.index')->with('success', "Kuis Selesai! Skor kamu: " . number_format($score, 1) . "% ($correct/$total)");
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted.');
    }
}
