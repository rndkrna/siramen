@extends('layouts.app', ['title' => 'Subjects'])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">Subjects</h1>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Add Subject</a>
    </div>

    @if ($subjects->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td><strong>{{ $subject->name }}</strong></td>
                        <td>{{ Str::limit($subject->description, 50) }}</td>
                        <td>{{ $subject->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('subjects.show', $subject) }}" class="btn" style="background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px;">View</a>
                            <a href="{{ route('subjects.edit', $subject) }}" class="btn" style="background-color: #8b5cf6; color: white; padding: 6px 12px; font-size: 12px;">Edit</a>
                            <form method="POST" action="{{ route('subjects.destroy', $subject) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
            <p style="color: #6b7280; margin-bottom: 20px;">No subjects found</p>
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">Create First Subject</a>
        </div>
    @endif
</div>
@endsection
