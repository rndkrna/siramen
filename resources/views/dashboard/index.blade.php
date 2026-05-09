@extends('layouts.app')

@section('content')
<div style="margin-top: 30px;">
    <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 30px; color: #1f2937;">Dashboard</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <!-- Stats Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 10px;">Total Subjects</h3>
            <p style="font-size: 28px; font-weight: bold; color: #3b82f6;">{{ $stats['subjects'] ?? 0 }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 10px;">Total Deadlines</h3>
            <p style="font-size: 28px; font-weight: bold; color: #8b5cf6;">{{ $stats['deadlines'] ?? 0 }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 10px;">Total Documents</h3>
            <p style="font-size: 28px; font-weight: bold; color: #ec4899;">{{ $stats['documents'] ?? 0 }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 10px;">Total Quizzes</h3>
            <p style="font-size: 28px; font-weight: bold; color: #f59e0b;">{{ $stats['quizzes'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Quick Actions</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Create Subject</a>
            <a href="{{ route('deadlines.create') }}" class="btn btn-primary">+ Create Deadline</a>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">+ Upload Document</a>
            <a href="{{ route('quizzes.index') }}" class="btn btn-primary">Create Quiz</a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Recent Activity</h2>
        <p style="color: #6b7280;">Activity logs will appear here...</p>
    </div>
</div>
@endsection
