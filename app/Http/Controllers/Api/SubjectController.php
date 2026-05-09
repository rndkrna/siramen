<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua mata kuliah milik user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return response()->json(['message' => 'No user found. Please seed the database.'], 404);
        }

        $subjects = Subject::where('user_id', $user->id)
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->has('is_active'), fn($q) => $q->where('is_active', $request->boolean('is_active')))
            ->get();

        return response()->json($subjects);
    }

    /**
     * Buat mata kuliah baru.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'color_hex' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'semester'  => 'nullable|integer|min:1|max:14',
        ]);

        $subject = Subject::create(array_merge($validated, [
            'user_id'   => $user->id,
            'is_active' => true,
        ]));

        return response()->json($subject, 201);
    }

    /**
     * Detail mata kuliah beserta deadlines & dokumen.
     */
    public function show(string $id): JsonResponse
    {
        $subject = Subject::with(['deadlines', 'documents'])->findOrFail($id);
        return response()->json($subject);
    }

    /**
     * Update mata kuliah.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'color_hex' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'semester'  => 'nullable|integer|min:1|max:14',
            'is_active' => 'sometimes|boolean',
        ]);

        $subject->update($validated);

        return response()->json($subject);
    }

    /**
     * Hapus mata kuliah (dan semua deadline + dokumen terkait).
     */
    public function destroy(string $id): JsonResponse
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['message' => 'Subject deleted successfully.']);
    }
}
