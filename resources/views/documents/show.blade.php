@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('documents.index') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <h1 style="margin-bottom: 0; font-size: 20px;">Detail Dokumen</h1>
    </div>
</div>

<div style="background: var(--card-bg); border-radius: 20px; padding: 24px; border: 1px solid var(--border-color); margin-bottom: 24px;">
    <div style="display: flex; gap: 16px; align-items: flex-start;">
        <div style="width: 48px; height: 48px; background: rgba(124, 77, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="file-text" style="color: var(--primary-purple);"></i>
        </div>
        <div style="flex: 1;">
            <h3 style="font-size: 18px; margin-bottom: 4px;">{{ $document->file_name }}</h3>
            <p style="font-size: 12px; color: var(--text-muted);">{{ $document->subject->name }} • {{ $document->file_size_kb }} KB</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ $document->file_url }}" target="_blank" style="background: #333; color: white; padding: 8px 16px; border-radius: 12px; text-decoration: none; font-size: 12px; font-weight: 600;">BUKA FILE</a>
        </div>
    </div>
</div>

@if($document->summary)
    <div class="summary-container" style="margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i data-lucide="sparkles" style="color: var(--primary-purple); width: 20px;"></i>
                <h4 style="font-size: 16px; font-weight: 600;">Ringkasan AI</h4>
            </div>
            <form action="{{ route('documents.quiz.generate', $document) }}" method="POST">
                @csrf
                <button type="submit" style="background: var(--primary-green); color: white; border: none; padding: 8px 16px; border-radius: 12px; font-size: 12px; font-weight: 700; cursor: pointer;">GENERATE KUIS</button>
            </form>
        </div>

        <div style="font-size: 14px; line-height: 1.6; color: #eee; margin-bottom: 24px;">
            {!! nl2br(e($document->summary->content_md)) !!}
        </div>

        <h4 style="font-size: 14px; color: var(--primary-purple); margin-bottom: 12px;">Poin Penting:</h4>
        <ul style="padding-left: 20px; color: var(--text-muted); font-size: 13px;">
            @foreach($document->summary->key_points as $point)
                <li style="margin-bottom: 8px;">{{ $point }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div style="background: var(--card-bg); border-radius: 20px; padding: 48px; text-align: center; border: 1px solid var(--border-color);">
        <i data-lucide="cpu" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
        <h3 style="margin-bottom: 12px;">Belum ada ringkasan</h3>
        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 24px;">Biarkan AI Siramen menganalisis dokumen ini untuk Anda.</p>
        
        <form action="{{ route('documents.summary.generate', $document) }}" method="POST">
            @csrf
            <button type="submit" style="background: var(--primary-purple); color: white; border: none; padding: 12px 32px; border-radius: 20px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple);">
                PROSES DENGAN AI
            </button>
        </form>
    </div>
@endif
@endsection
