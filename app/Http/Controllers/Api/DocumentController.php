<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua dokumen milik user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $documents = Document::where('user_id', $user->id)
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return response()->json($documents);
    }

    /**
     * Upload dokumen baru.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,txt|max:10240', // max 10MB
            'subject_id' => 'nullable|exists:subjects,id',
            'is_lab' => 'nullable|boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents/' . $user->id, 'public');

        $document = Document::create([
            'user_id' => $user->id,
            'subject_id' => $request->subject_id,
            'file_name' => $file->getClientOriginalName(),
            'file_url' => Storage::url($path),
            'mime_type' => $file->getMimeType(),
            'file_size_kb' => round($file->getSize() / 1024),
            'status' => 'uploaded',
            'is_lab' => $request->is_lab ?? false,
            'uploaded_at' => now(),
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'data' => $document
        ], 201);
    }

    /**
     * Detail dokumen tertentu.
     */
    public function show(string $id): JsonResponse
    {
        $document = Document::with(['summary', 'quizzes'])->findOrFail($id);
        return response()->json($document);
    }

    /**
     * Hapus dokumen.
     */
    public function destroy(string $id): JsonResponse
    {
        $document = Document::findOrFail($id);

        // Hapus file fisik (ambil path dari URL)
        $path = str_replace('/storage/', '', $document->file_url);
        Storage::disk('public')->delete($path);

        $document->delete();

        return response()->json(['message' => 'Document deleted successfully.']);
    }
}
