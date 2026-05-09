<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Summary;
use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SummaryController extends Controller
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
     * Ambil summary dokumen tertentu.
     */
    public function show(string $documentId): JsonResponse
    {
        $summary = Summary::where('document_id', $documentId)->first();

        if (!$summary) {
            return response()->json(['message' => 'Summary belum dibuat. Gunakan endpoint /generate.'], 404);
        }

        return response()->json($summary);
    }

    /**
     * Generate summary baru.
     */
    public function generate(string $documentId): JsonResponse
    {
        $document = Document::findOrFail($documentId);

        // Ekstrak teks dari file (untuk sekarang pakai file_name sebagai fallback)
        // TODO: gunakan library smalot/pdfparser untuk PDF nyata
        $extractedText = $this->extractTextFromDocument($document);

        $result = $this->gemini->generateSummary($extractedText);

        if (!$result) {
            return response()->json(['message' => 'Gagal generate summary. Periksa GEMINI_API_KEY di .env.'], 500);
        }

        $summary = Summary::updateOrCreate(
            ['document_id' => $documentId],
            [
                'content_md'         => $result['content_md'] ?? '',
                'key_points'         => $result['key_points'] ?? [],
                'possible_questions' => $result['possible_questions'] ?? [],
                'language'           => $result['language'] ?? 'id',
                'tokens_used'        => 0,
            ]
        );

        // Update status dokumen
        $document->update(['status' => 'summarized']);

        return response()->json([
            'message' => 'Summary berhasil dibuat.',
            'data'    => $summary,
        ], 201);
    }

    /**
     * Hapus summary lama lalu generate ulang.
     */
    public function regenerate(string $documentId): JsonResponse
    {
        Summary::where('document_id', $documentId)->delete();
        return $this->generate($documentId);
    }

    /**
     * Helper: ekstrak teks dari file dokumen.
     */
    private function extractTextFromDocument(Document $document): string
    {
        // Coba baca file dari storage
        $path = str_replace('/storage/', '', $document->file_url);

        if (Storage::disk('public')->exists($path)) {
            $extension = pathinfo($document->file_name, PATHINFO_EXTENSION);

            if (strtolower($extension) === 'txt') {
                return Storage::disk('public')->get($path);
            }

            // Untuk PDF/DOCX: fallback ke metadata dokumen
            // TODO: integrasikan smalot/pdfparser untuk PDF extraction penuh
        }

        // Fallback minimal jika file tidak bisa dibaca
        return "Dokumen berjudul: '{$document->file_name}'. "
            . "Ukuran: {$document->file_size_kb} KB. "
            . "Tipe: {$document->mime_type}. "
            . "Tolong buat ringkasan umum berdasarkan judul dokumen ini.";
    }
}
