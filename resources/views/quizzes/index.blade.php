@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Generator Soal</h1>
</div>

<!-- Konfigurasi -->
<div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
        <i data-lucide="settings" style="color: var(--primary-green); width: 18px;"></i>
        <h4 style="font-size: 16px; font-weight: 600;">Buat Kuis Baru</h4>
    </div>
    
    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">Pilih dokumen yang sudah diupload, lalu biarkan AI membuatkan soal latihan untuk Anda secara otomatis.</p>

    <a href="{{ route('documents.index') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: var(--primary-purple); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; box-shadow: var(--shadow-purple);">
        <i data-lucide="plus-circle" style="width: 16px;"></i>
        PILIH DOKUMEN & GENERATE KUIS
    </a>
</div>

<!-- Daftar Quiz -->
<div style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i data-lucide="zap" style="color: var(--primary-purple); width: 18px;"></i>
            <h4 style="font-size: 16px; font-weight: 600;">Daftar Kuis Tersedia</h4>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
        @forelse($quizzes as $quiz)
        <div style="background: var(--card-bg); border-radius: 20px; padding: 24px; border: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">{{ $quiz->title }}</h4>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">
                    <i data-lucide="file-text" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i>
                    {{ $quiz->document ? $quiz->document->file_name : 'No Document' }}
                </p>
                <p style="font-size: 12px; color: var(--text-muted);">
                    <i data-lucide="help-circle" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i>
                    {{ $quiz->total_questions }} Soal
                </p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('quizzes.show', $quiz) }}" style="background: var(--primary-purple); color: white; border: none; padding: 10px 24px; border-radius: 20px; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-purple); text-decoration: none; display: inline-block;">MULAI KUIS</a>
                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus kuis ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: transparent; border: none; color: var(--accent-red); cursor: pointer;"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                </form>
            </div>
        </div>
        @empty
        <div style="background: var(--card-bg); border-radius: 20px; padding: 40px; border: 1px solid var(--border-color); text-align: center;">
            <i data-lucide="brain" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
            <p style="color: var(--text-muted); margin-bottom: 16px;">Belum ada kuis yang di-generate.</p>
            <a href="{{ route('documents.index') }}" style="background: var(--primary-purple); color: white; border: none; padding: 10px 24px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block;">Pilih Dokumen & Buat Kuis</a>
        </div>
        @endforelse
    </div>
</div>

<!-- Pencapaian (Static for now) -->
<div>
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i data-lucide="medal" style="color: #FFD600; width: 18px;"></i>
        <h4 style="font-size: 16px; font-weight: 600;">Pencapaian Terakhir</h4>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
        <div class="achievement-card">
            <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">SKOR RATA-RATA</p>
            <h3 style="font-size: 24px; font-weight: 700; color: white;">{{ number_format($avgScore, 0) }}%</h3>
            <p style="font-size: 9px; color: var(--primary-green); margin-top: 4px;">{{ $totalCompleted }} Kuis Selesai</p>
        </div>
        <div class="achievement-card">
            <div class="achievement-icon" style="color: var(--primary-purple);"><i data-lucide="zap"></i></div>
            <h4 style="font-size: 11px; font-weight: 700;">Flash Thinker</h4>
            <p style="font-size: 8px; color: var(--text-muted);">Terus Berlatih!</p>
        </div>
        <div class="achievement-card">
            <div class="achievement-icon" style="color: var(--primary-green);"><i data-lucide="check-circle"></i></div>
            <h4 style="font-size: 11px; font-weight: 700;">Precision King</h4>
            <p style="font-size: 8px; color: var(--text-muted);">Akurasi Jawaban</p>
        </div>
    </div>
</div>

@endsection
