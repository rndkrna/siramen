@extends('layouts.app', ['title' => 'Upload Document'])

@section('content')
<div style="margin-top: 30px; max-width: 600px;">
    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 30px; color: #1f2937;">Upload Document</h1>

    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf

        <div class="form-group">
            <label for="title">Document Title *</label>
            <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="e.g., Chapter 1 - Introduction">
        </div>

        <div class="form-group">
            <label for="subject_id">Subject *</label>
            <select id="subject_id" name="subject_id" required>
                <option value="">Select a subject</option>
                @forelse ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @empty
                    <option disabled>No subjects available</option>
                @endforelse
            </select>
        </div>

        <div class="form-group">
            <label for="file">Choose File *</label>
            <input type="file" id="file" name="file" required accept=".pdf,.doc,.docx,.txt,.xlsx,.ppt,.pptx">
            <small style="color: #6b7280; display: block; margin-top: 8px;">Supported: PDF, DOC, DOCX, TXT, XLSX, PPT, PPTX (Max 50MB)</small>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Describe this document..." rows="4">{{ old('description') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Upload Document</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Cancel</a>
        </div>
    </form>
</div>
@endsection
