<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Daftar semua mata kuliah milik user.
     * GET /api/subjects
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return user subjects, filter by is_active, semester
    }

    /**
     * Buat mata kuliah baru.
     * POST /api/subjects
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: validate & create subject
    }

    /**
     * Detail mata kuliah tertentu.
     * GET /api/subjects/{subject}
     */
    public function show(string $id): JsonResponse
    {
        // TODO: return subject dengan deadlines & documents
    }

    /**
     * Update mata kuliah.
     * PUT /api/subjects/{subject}
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // TODO: validate & update subject
    }

    /**
     * Hapus mata kuliah.
     * DELETE /api/subjects/{subject}
     */
    public function destroy(string $id): JsonResponse
    {
        // TODO: soft delete or hard delete subject
    }
}
