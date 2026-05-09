@extends('layouts.app', ['title' => 'Edit Subject'])

@section('content')
<div style="margin-top: 30px; max-width: 600px;">
    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 30px; color: #1f2937;">Edit Subject</h1>

    <form method="POST" action="{{ route('subjects.update', $subject) }}" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Subject Name *</label>
            <input type="text" id="name" name="name" required value="{{ old('name', $subject->name) }}" placeholder="e.g., Mathematics">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Describe this subject..." rows="4">{{ old('description', $subject->description) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Subject</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Cancel</a>
        </div>
    </form>
</div>
@endsection
