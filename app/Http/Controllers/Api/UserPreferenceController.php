<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    /**
     * Tampilkan preferensi user. Buat default jika belum ada.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $preference = UserPreference::firstOrCreate(
            ['user_id' => $user->id],
            [
                'theme'          => 'dark',
                'language'       => 'id',
                'notif_hour'     => 8,
                'notif_enabled'  => true,
                'summary_lang'   => 'id',
            ]
        );

        return response()->json($preference);
    }

    /**
     * Update preferensi user.
     */
    public function update(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'theme'         => 'sometimes|in:dark,light',
            'language'      => 'sometimes|string|max:10',
            'notif_hour'    => 'sometimes|integer|min:0|max:23',
            'notif_enabled' => 'sometimes|boolean',
            'summary_lang'  => 'sometimes|string|max:10',
        ]);

        $preference = UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return response()->json($preference);
    }
}
