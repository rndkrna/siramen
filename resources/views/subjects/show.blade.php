@extends('layouts.app', ['title' => $subject->name])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">{{ $subject->name }}</h1>
            <p style="color: #6b7280; margin-top: 5px;">Created on {{ $subject->created_at->format('F j, Y') }}</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Back</a>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Description</h2>
        <p style="color: #374151; line-height: 1.6;">{{ $subject->description ?? 'No description provided' }}</p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Subject Details</h2>
        <table style="width: 100%; border: 1px solid #e5e7eb;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb; width: 30%;">ID</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $subject->id }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Created At</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $subject->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600; background-color: #f9fafb;">Updated At</td>
                <td style="padding: 10px;">{{ $subject->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <form method="POST" action="{{ route('subjects.destroy', $subject) }}" onsubmit="return confirm('Are you sure you want to delete this subject?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Subject</button>
    </form>
</div>
@endsection
