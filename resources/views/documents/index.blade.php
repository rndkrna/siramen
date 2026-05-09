@extends('layouts.app', ['title' => 'Documents'])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">Documents</h1>
        <a href="{{ route('documents.create') }}" class="btn btn-primary">+ Upload Document</a>
    </div>

    @if ($documents->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>File Type</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td><strong>{{ $document->title }}</strong></td>
                        <td>{{ $document->subject?->name ?? 'N/A' }}</td>
                        <td>{{ strtoupper($document->file_type) }}</td>
                        <td>{{ number_format($document->file_size / 1024 / 1024, 2) }} MB</td>
                        <td>{{ $document->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('documents.show', $document) }}" class="btn" style="background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px;">View</a>
                            <form method="POST" action="{{ route('documents.destroy', $document) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background-color: #f3f4f6; padding: 40px; border-radius: 8px; text-align: center;">
            <p style="color: #6b7280; margin-bottom: 20px;">No documents found</p>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">Upload First Document</a>
        </div>
    @endif
</div>
@endsection
