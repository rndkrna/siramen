<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    /**
     * Daftar semua deadline milik user.
     * GET /api/deadlines
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return deadlines, filter by is_done, due_date, subject_id, priority
    }

    /**
     * Buat deadline baru.
     * POST /api/deadlines
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: validate & create deadline
    }

    /**
     * Detail deadline tertentu.
     * GET /api/deadlines/{deadline}
     */
    public function show(string $id): JsonResponse
    {
        // TODO: return deadline dengan notifications
    }

    /**
     * Update deadline.
     * PUT /api/deadlines/{deadline}
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // TODO: validate & update deadline
    }

    /**
     * Tandai deadline selesai / belum selesai.
     * PATCH /api/deadlines/{deadline}/toggle
     */
    public function toggle(string $id): JsonResponse
    {
        // TODO: flip is_done field
    }

    /**
     * Hapus deadline.
     * DELETE /api/deadlines/{deadline}
     */
    public function destroy(string $id): JsonResponse
    {
        // TODO: delete deadline
    }
}
