<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Ambil summary dari dokumen tertentu.
     * GET /api/documents/{document}/summary
     */
    public function show(string $documentId): JsonResponse
    {
        // TODO: return summary milik document
    }

    /**
     * Generate summary baru dari dokumen (trigger AI).
     * POST /api/documents/{document}/summary/generate
     */
    public function generate(string $documentId): JsonResponse
    {
        // TODO: dispatch job GenerateSummaryJob, return 202 Accepted
    }

    /**
     * Regenerate summary (hapus lama, generate baru).
     * POST /api/documents/{document}/summary/regenerate
     */
    public function regenerate(string $documentId): JsonResponse
    {
        // TODO: hapus summary lama, dispatch GenerateSummaryJob
    }
}
