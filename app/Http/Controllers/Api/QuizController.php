<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Daftar semua quiz milik user.
     * GET /api/quizzes
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return quizzes milik user, filter by document_id
    }

    /**
     * Generate quiz baru dari dokumen (trigger AI).
     * POST /api/documents/{document}/quiz/generate
     */
    public function generate(string $documentId): JsonResponse
    {
        // TODO: dispatch GenerateQuizJob, return 202 Accepted
    }

    /**
     * Detail quiz tertentu beserta soalnya.
     * GET /api/quizzes/{quiz}
     */
    public function show(string $id): JsonResponse
    {
        // TODO: return quiz dengan questions (sembunyikan correct_answer di sini)
    }

    /**
     * Hapus quiz.
     * DELETE /api/quizzes/{quiz}
     */
    public function destroy(string $id): JsonResponse
    {
        // TODO: delete quiz dan questions-nya
    }
}
