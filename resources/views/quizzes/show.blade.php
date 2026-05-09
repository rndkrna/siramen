@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('quizzes.index') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0; font-size: 20px;">Latihan Kuis</h1>
</div>

<div style="margin-bottom: 24px;">
    <h2 style="font-size: 18px; margin-bottom: 8px;">{{ $quiz->title }}</h2>
    <p style="font-size: 12px; color: var(--text-muted);">{{ $quiz->total_questions }} Pertanyaan • Dari: {{ $quiz->document->file_name }}</p>
</div>

<form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
    @csrf
    @foreach($quiz->questions as $index => $question)
    <div style="background: var(--card-bg); border-radius: 20px; padding: 24px; border: 1px solid var(--border-color); margin-bottom: 20px;">
        <p style="font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
            <span style="color: var(--primary-purple); font-weight: 700; margin-right: 8px;">{{ $index + 1 }}.</span>
            {{ $question->question_text }}
        </p>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($question->options as $optIndex => $option)
            <label style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.03); padding: 14px; border-radius: 12px; cursor: pointer; border: 1px solid transparent;" onmouseover="this.style.borderColor='var(--border-color)'" onmouseout="this.style.borderColor='transparent'">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optIndex }}" required>
                <span style="font-size: 13px;">{{ $option }}</span>
            </label>
            @endforeach
        </div>
    </div>
    @endforeach

    <button type="submit" style="width: 100%; background: var(--primary-purple); color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple); margin-bottom: 40px;">
        SELESAIKAN KUIS
    </button>
</form>
@endsection
