<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua deadline milik user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $deadlines = Deadline::where('user_id', $user->id)
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->when($request->has('is_done'), fn($q) => $q->where('is_done', $request->boolean('is_done')))
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json($deadlines);
    }

    /**
     * Buat deadline baru.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        $deadline = Deadline::create(array_merge($validated, [
            'user_id' => $user->id,
            'is_done' => false,
        ]));

        return response()->json($deadline, 201);
    }

    /**
     * Detail deadline tertentu.
     */
    public function show(string $id): JsonResponse
    {
        $deadline = Deadline::with('subject')->findOrFail($id);
        return response()->json($deadline);
    }

    /**
     * Update deadline.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $deadline = Deadline::findOrFail($id);

        $validated = $request->validate([
            'subject_id' => 'sometimes|exists:subjects,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|date',
            'priority' => 'sometimes|in:low,medium,high',
            'is_done' => 'sometimes|boolean',
        ]);

        $deadline->update($validated);

        return response()->json($deadline);
    }

    /**
     * Tandai deadline selesai / belum selesai.
     */
    public function toggle(string $id): JsonResponse
    {
        $deadline = Deadline::findOrFail($id);
        $deadline->update(['is_done' => !$deadline->is_done]);

        return response()->json($deadline);
    }

    /**
     * Hapus deadline.
     */
    public function destroy(string $id): JsonResponse
    {
        $deadline = Deadline::findOrFail($id);
        $deadline->delete();

        return response()->json(['message' => 'Deadline deleted successfully.']);
    }
}
