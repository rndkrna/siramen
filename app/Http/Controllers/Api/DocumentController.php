<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Daftar semua dokumen milik user.
     * GET /api/documents
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return documents, filter by subject_id, status, mime_type
    }

    /**
     * Upload dokumen baru.
     * POST /api/documents
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: validate file, upload to storage, create document record
    }

    /**
     * Detail dokumen tertentu.
     * GET /api/documents/{document}
     */
    public function show(string $id): JsonResponse
    {
        // TODO: return document dengan summary & quizzes
    }

    /**
     * Hapus dokumen.
     * DELETE /api/documents/{document}
     */
    public function destroy(string $id): JsonResponse
    {
        // TODO: hapus file dari storage, hapus record
    }
}
