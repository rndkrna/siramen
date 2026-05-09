<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $user = auth()->user() ?? \App\Models\User::first();
        
        $teams = \App\Models\Team::where('user_id', $user->id)
            ->orWhereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['members', 'tasks'])
            ->get();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user() ?? \App\Models\User::first();

        $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
        ]);

        $team = \App\Models\Team::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        // Add owner as member
        \App\Models\TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'name' => $user->full_name,
            'role' => 'Project Lead',
            'progress' => 0,
        ]);

        return redirect()->route('teams.index')->with('success', 'Kelompok berhasil dibuat!');
    }

    public function storeMember(Request $request, \App\Models\Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'nullable|email',
            'role' => 'nullable|string|max:100',
        ]);

        $linkedUser = null;
        if ($request->email) {
            $linkedUser = \App\Models\User::where('email', $request->email)->first();
        }

        \App\Models\TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $linkedUser ? $linkedUser->id : null,
            'name' => $request->name,
            'role' => $request->role ?? 'Member',
            'progress' => 0,
        ]);

        return back()->with('success', $linkedUser ? 'Anggota berhasil ditambahkan dan ditautkan ke akun!' : 'Anggota berhasil ditambahkan!');
    }

    public function storeTask(Request $request, \App\Models\Team $team)
    {
        $request->validate([
            'task_name' => 'required|string|max:191',
            'priority' => 'required|in:low,medium,high',
        ]);

        \App\Models\TeamTask::create([
            'team_id' => $team->id,
            'task_name' => $request->task_name,
            'status' => 'pending',
            'priority' => $request->priority,
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function destroy(\App\Models\Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Kelompok dihapus.');
    }
}
