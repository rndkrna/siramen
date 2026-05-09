@extends('layouts.app', ['title' => $document->title])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">{{ $document->title }}</h1>
            <p style="color: #6b7280; margin-top: 5px;">Subject: {{ $document->subject?->name ?? 'N/A' }}</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ $document->file_path }}" class="btn btn-primary" download>Download File</a>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Back</a>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Document Details</h2>
        <table style="width: 100%; border: 1px solid #e5e7eb;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb; width: 30%;">File Type</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ strtoupper($document->file_type) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">File Size</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ number_format($document->file_size / 1024 / 1024, 2) }} MB</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Uploaded</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $document->created_at->format('F j, Y H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600; background-color: #f9fafb;">Updated</td>
                <td style="padding: 10px;">{{ $document->updated_at->format('F j, Y H:i') }}</td>
            </tr>
        </table>
    </div>

    @if ($document->description)
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Description</h2>
            <p style="color: #374151; line-height: 1.6;">{{ $document->description }}</p>
        </div>
    @endif

    @if ($document->summary)
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">
                Summary
                <a href="{{ route('documents.summary.generate', $document) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Regenerate</a>
            </h2>
            <p style="color: #374151; line-height: 1.6;">{{ $document->summary->content }}</p>
        </div>
    @else
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <form method="POST" action="{{ route('documents.summary.generate', $document) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary">Generate Summary</button>
            </form>
        </div>
    @endif
</div>
@endsection
