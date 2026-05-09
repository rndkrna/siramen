<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Daftar semua notifikasi user.
     * GET /api/notifications
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return notifications, filter by is_sent, channel
    }

    /**
     * Tandai notifikasi sudah dikirim / dibaca.
     * PATCH /api/notifications/{notification}/mark-sent
     */
    public function markSent(string $id): JsonResponse
    {
        // TODO: set is_sent = true, sent_at = now()
    }

    /**
     * Hapus notifikasi.
     * DELETE /api/notifications/{notification}
     */
    public function destroy(string $id): JsonResponse
    {
        // TODO: delete notification
    }
}
