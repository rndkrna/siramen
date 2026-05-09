<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Daftar aktivitas user.
     * GET /api/activity-logs
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: return activity logs user, filter by action, entity_type, date range
    }
}
