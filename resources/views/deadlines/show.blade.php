@extends('layouts.app', ['title' => $deadline->title])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">{{ $deadline->title }}</h1>
            <p style="color: #6b7280; margin-top: 5px;">Subject: {{ $deadline->subject?->name ?? 'N/A' }}</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('deadlines.edit', $deadline) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('deadlines.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Back</a>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Deadline Details</h2>
        <table style="width: 100%; border: 1px solid #e5e7eb;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb; width: 30%;">Due Date</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $deadline->due_date->format('F j, Y H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Status</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                    <span style="padding: 4px 8px; border-radius: 4px; font-weight: 500; background-color: {{ $deadline->is_completed ? '#d1fae5' : '#fef3c7' }}; color: {{ $deadline->is_completed ? '#065f46' : '#92400e' }};">
                        {{ $deadline->is_completed ? 'Completed' : 'Pending' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Created</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $deadline->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600; background-color: #f9fafb;">Updated</td>
                <td style="padding: 10px;">{{ $deadline->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>

    @if ($deadline->description)
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Description</h2>
            <p style="color: #374151; line-height: 1.6;">{{ $deadline->description }}</p>
        </div>
    @endif
</div>
@endsection
