<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Redirect ke provider OAuth (Google, GitHub, dll).
     * GET /api/auth/{provider}/redirect
     */
    public function redirect(string $provider): JsonResponse
    {
        // TODO: return Socialite redirect URL
    }

    /**
     * Tangani callback dari provider OAuth.
     * GET /api/auth/{provider}/callback
     */
    public function callback(string $provider): JsonResponse
    {
        // TODO: upsert user, buat token Sanctum, return user + token
    }

    /**
     * Logout — cabut token aktif.
     * POST /api/auth/logout
     */
    public function logout(Request $request): JsonResponse
    {
        // TODO: $request->user()->currentAccessToken()->delete()
    }

    /**
     * Kembalikan data user yang sedang login.
     * GET /api/auth/me
     */
    public function me(Request $request): JsonResponse
    {
        // TODO: return auth user dengan preference
    }
}
