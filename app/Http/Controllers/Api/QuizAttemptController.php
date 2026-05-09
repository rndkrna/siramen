<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    /**
     * Daftar semua attempt pada quiz tertentu (milik user).
     * GET /api/quizzes/{quiz}/attempts
     */
    public function index(string $quizId): JsonResponse
    {
        // TODO: return attempts milik user pada quiz tersebut
    }

    /**
     * Submit jawaban quiz — buat attempt baru.
     * POST /api/quizzes/{quiz}/attempts
     */
    public function store(Request $request, string $quizId): JsonResponse
    {
        // TODO: validate answers_json, hitung score, simpan attempt
    }

    /**
     * Detail satu attempt (termasuk jawaban benar).
     * GET /api/quizzes/{quiz}/attempts/{attempt}
     */
    public function show(string $quizId, string $attemptId): JsonResponse
    {
        // TODO: return attempt dengan detail jawaban & correct answers
    }
}
