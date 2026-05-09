@extends('layouts.app', ['title' => $quiz->title])

@section('content')
<div style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937;">{{ $quiz->title }}</h1>
            <p style="color: #6b7280; margin-top: 5px;">Subject: {{ $quiz->subject?->name ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary" style="background-color: #6b7280;">Back</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 15px;">Quiz Details</h2>
        <table style="width: 100%; border: 1px solid #e5e7eb;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb; width: 30%;">Total Questions</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $quiz->questions_count ?? 0 }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Document</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                    @if ($quiz->document)
                        <a href="{{ route('documents.show', $quiz->document) }}" style="color: #3b82f6; text-decoration: none;">
                            {{ $quiz->document->title }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Created</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">{{ $quiz->created_at->format('F j, Y H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600; background-color: #f9fafb;">Updated</td>
                <td style="padding: 10px;">{{ $quiz->updated_at->format('F j, Y H:i') }}</td>
            </tr>
        </table>
    </div>

    @if ($quiz->questions->count() > 0)
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Questions ({{ $quiz->questions->count() }})</h2>
            
            @foreach ($quiz->questions as $index => $question)
                <div style="padding: 15px; border-left: 4px solid #3b82f6; background-color: #f9fafb; margin-bottom: 15px; border-radius: 4px;">
                    <p style="font-weight: 600; margin-bottom: 10px;">{{ $index + 1 }}. {{ $question->question }}</p>
                    <ul style="margin-left: 20px; margin-bottom: 10px;">
                        @if (isset($question->options) && is_array($question->options))
                            @foreach ($question->options as $option)
                                <li style="margin-bottom: 5px;">{{ $option }}</li>
                            @endforeach
                        @endif
                    </ul>
                    @if ($question->correct_answer)
                        <p style="color: #065f46; font-weight: 500;">✓ Correct Answer: {{ $question->correct_answer }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div style="background-color: #f3f4f6; padding: 40px; border-radius: 8px; text-align: center;">
            <p style="color: #6b7280;">No questions in this quiz</p>
        </div>
    @endif
</div>
@endsection
