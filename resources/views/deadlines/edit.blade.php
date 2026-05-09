@extends('layouts.app', ['title' => 'Edit Deadline'])

@section('content')
<div style="margin-top: 30px; max-width: 600px;">
    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 30px; color: #1f2937;">Edit Deadline</h1>

    <form method="POST" action="{{ route('deadlines.update', $deadline) }}" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Deadline Title *</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $deadline->title) }}" placeholder="e.g., Math Assignment #1">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Describe the deadline..." rows="4">{{ old('description', $deadline->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="subject_id">Subject *</label>
            <select id="subject_id" name="subject_id" required>
                <option value="">Select a subject</option>
                @forelse ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id', $deadline->subject_id) == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @empty
                    <option disabled>No subjects available</option>
                @endforelse
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date & Time *</label>
            <input type="datetime-local" id="due_date" name="due_date" required value="{{ old('due_date', $deadline->due_date->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="form-group">
            <label for="is_completed">
                <input type="checkbox" id="is_completed" name="is_completed" value="1" {{ $deadline->is_completed ? 'checked' : '' }}>
                Mark as Completed
            </label>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Deadline</button>
            <a href="{{ route('deadlines.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Cancel</a>
        </div>
    </form>
</div>
@endsection
