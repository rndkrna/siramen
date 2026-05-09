@extends('layouts.app', ['title' => 'Deadlines'])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">Deadlines</h1>
        <a href="{{ route('deadlines.create') }}" class="btn btn-primary">+ Add Deadline</a>
    </div>

    @if ($deadlines->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deadlines as $deadline)
                    <tr>
                        <td>{{ $deadline->id }}</td>
                        <td><strong>{{ $deadline->title }}</strong></td>
                        <td>{{ $deadline->subject?->name ?? 'N/A' }}</td>
                        <td>{{ $deadline->due_date->format('Y-m-d H:i') }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; background-color: {{ $deadline->is_completed ? '#d1fae5' : '#fef3c7' }}; color: {{ $deadline->is_completed ? '#065f46' : '#92400e' }};">
                                {{ $deadline->is_completed ? 'Completed' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('deadlines.show', $deadline) }}" class="btn" style="background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px;">View</a>
                            <a href="{{ route('deadlines.edit', $deadline) }}" class="btn" style="background-color: #8b5cf6; color: white; padding: 6px 12px; font-size: 12px;">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background-color: #f3f4f6; padding: 40px; border-radius: 8px; text-align: center;">
            <p style="color: #6b7280; margin-bottom: 20px;">No deadlines found</p>
            <a href="{{ route('deadlines.create') }}" class="btn btn-primary">Create First Deadline</a>
        </div>
    @endif
</div>
@endsection
