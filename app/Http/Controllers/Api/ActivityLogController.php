<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar aktivitas user, dengan filter opsional.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $logs = ActivityLog::where('user_id', $user->id)
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->entity_type, fn($q) => $q->where('entity_type', $request->entity_type))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($logs);
    }
}
