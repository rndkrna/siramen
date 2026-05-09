<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\Document;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user() ?? User::first();

        $stats = [
            'subjects_count' => Subject::where('user_id', $user->id)->count(),
            'deadlines_count' => Deadline::where('user_id', $user->id)->where('is_done', false)->count(),
            'documents_count' => Document::where('user_id', $user->id)->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
