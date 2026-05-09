<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private function getCurrentUser()
    {
        return auth()->user() ?? User::first();
    }

    public function index()
    {
        $user = $this->getCurrentUser();
        $subjects = Subject::where('user_id', $user->id)
            ->withCount(['documents', 'deadlines'])
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_hex' => 'nullable|string|max:7',
            'semester' => 'nullable|integer',
        ]);

        Subject::create(array_merge($validated, [
            'user_id' => $user->id,
            'is_active' => true,
        ]));

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_hex' => 'nullable|string|max:7',
            'semester' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
