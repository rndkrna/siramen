@extends('layouts.app', ['title' => 'Quizzes'])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">Quizzes</h1>
    </div>

    @if ($quizzes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Questions</th>
                    <th>Document</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td><strong>{{ $quiz->title }}</strong></td>
                        <td>{{ $quiz->subject?->name ?? 'N/A' }}</td>
                        <td>{{ $quiz->questions_count }}</td>
                        <td>{{ $quiz->document?->title ?? 'N/A' }}</td>
                        <td>{{ $quiz->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('quizzes.show', $quiz) }}" class="btn" style="background-color: #3b82f6; color: white; padding: 6px 12px; font-size: 12px;">View</a>
                            <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
            <p style="color: #6b7280; margin-bottom: 20px;">No quizzes found</p>
            <p style="color: #6b7280; font-size: 14px;">Quizzes are generated automatically from documents</p>
        </div>
    @endif
</div>
@endsection
