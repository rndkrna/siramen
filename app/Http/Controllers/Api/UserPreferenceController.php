<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * Tampilkan preferensi user yang login.
     * GET /api/preferences
     */
    public function show(Request $request): JsonResponse
    {
        // TODO: return user preference (buat default jika belum ada)
    }

    /**
     * Update preferensi user.
     * PUT /api/preferences
     */
    public function update(Request $request): JsonResponse
    {
        // TODO: validate & updateOrCreate user preference
    }
}
