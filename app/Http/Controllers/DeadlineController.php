<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    public function index(Request $request)
    {
        $user = $this->getCurrentUser();
        $query = Deadline::where('user_id', $user->id);

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $deadlines = $query->with('subject')
            ->orderBy('due_date', 'asc')
            ->get();

        $subjects = Subject::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        return view('deadlines.index', compact('deadlines', 'subjects'));
    }

    public function create()
    {
        $user = $this->getCurrentUser();
        $subjects = Subject::where('user_id', $user->id)->get();
        return view('deadlines.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'type' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        Deadline::create(array_merge($validated, [
            'user_id' => $user->id,
            'is_done' => false,
        ]));

        return redirect()->route('deadlines.index')->with('success', 'Deadline added successfully.');
    }

    public function edit(Deadline $deadline)
    {
        $user = $this->getCurrentUser();
        $subjects = Subject::where('user_id', $user->id)->get();
        return view('deadlines.edit', compact('deadline', 'subjects'));
    }

    public function update(Request $request, Deadline $deadline)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'is_done' => 'boolean',
        ]);

        $deadline->update($validated);

        return redirect()->route('deadlines.index')->with('success', 'Deadline updated.');
    }

    public function destroy(Deadline $deadline)
    {
        $deadline->delete();
        return redirect()->route('deadlines.index')->with('success', 'Deadline deleted.');
    }
}
