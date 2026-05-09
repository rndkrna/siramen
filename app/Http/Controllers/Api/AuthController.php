<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect ke provider OAuth (Google, GitHub, dll).
     */
    public function redirect(string $provider): JsonResponse
    {
        $validProviders = ['google', 'github'];

        if (!in_array($provider, $validProviders)) {
            return response()->json(['message' => "Provider '{$provider}' tidak didukung."], 422);
        }

        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        $url = $driver->stateless()->redirect()->getTargetUrl();

        return response()->json(['redirect_url' => $url]);
    }

    /**
     * Tangani callback dari provider OAuth — buat atau update user, return token.
     */
    public function callback(string $provider): JsonResponse
    {
        $validProviders = ['google', 'github'];

        if (!in_array($provider, $validProviders)) {
            return response()->json(['message' => "Provider '{$provider}' tidak didukung."], 422);
        }

        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver($provider);
            $socialUser = $driver->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['message' => 'OAuth callback gagal: ' . $e->getMessage()], 401);
        }

        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'full_name'  => $socialUser->getName(),
                'avatar_url' => $socialUser->getAvatar(),
                'provider'   => $provider,
            ]
        );

        // Cabut semua token lama, buat token baru
        $user->tokens()->delete();
        $token = $user->createToken('siramen-app')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    /**
     * Logout — cabut token yang sedang aktif.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = auth()->user() ?? User::first();

        if ($user && $request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logout berhasil.']);
    }

    /**
     * Kembalikan data user yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        $user = auth()->user() ?? User::first();

        if (!$user) {
            return response()->json(['message' => 'Tidak ada user aktif.'], 401);
        }

        return response()->json($user->load('preference'));
    }
}
