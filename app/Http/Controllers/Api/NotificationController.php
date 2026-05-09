<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Daftar semua notifikasi user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $notifications = Notification::where('user_id', $user->id)
            ->when($request->has('is_sent'), fn($q) => $q->where('is_sent', $request->boolean('is_sent')))
            ->when($request->channel, fn($q) => $q->where('channel', $request->channel))
            ->with('deadline')
            ->orderByDesc('id')
            ->get();

        return response()->json($notifications);
    }

    /**
     * Tandai notifikasi sudah dikirim / dibaca.
     */
    public function markSent(string $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);
        $notification->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);

        return response()->json($notification);
    }

    /**
     * Hapus notifikasi.
     */
    public function destroy(string $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully.']);
    }
}
