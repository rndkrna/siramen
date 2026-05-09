@extends('layouts.app')

@section('content')
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Halo, Selamat Datang!</h2>
    <p style="color: var(--text-muted); font-size: 14px;">Apa yang ingin kamu kerjakan hari ini?</p>
</div>

<div class="menu-grid">
    <!-- Ringkas Materi -->
    <a href="{{ route('documents.create') }}" class="menu-card">
        <i data-lucide="file-text"></i>
        <div>
            <h3>Ringkas Materi Kuliah</h3>
            <p>Upload PDF slide/modul, langsung dapat rangkuman + poin penting.</p>
        </div>
        <div style="margin-top: auto;">
            <span class="badge badge-purple">AI · NLP</span>
        </div>
    </a>

    <!-- Manajemen Deadline -->
    <a href="{{ route('deadlines.index') }}" class="menu-card">
        <i data-lucide="calendar" style="color: var(--primary-green);"></i>
        <div>
            <h3>Manajemen Deadline</h3>
            <p>Input jadwal UTS, tugas, dan seminar. Sistem otomatis ingatkan H-7.</p>
        </div>
        <div style="margin-top: auto;">
            <span style="font-size: 10px; color: var(--primary-green);">Kalender · Notif</span>
        </div>
    </a>

    <!-- Generator Soal -->
    <a href="{{ route('quizzes.index') }}" class="menu-card">
        <i data-lucide="brain" style="color: #FFD600;"></i>
        <div>
            <h3>Generator Soal Latihan</h3>
            <p>Buat kuis otomatis dari materi kuliah Anda untuk belajar mandiri.</p>
        </div>
        <div style="margin-top: auto;">
            <span style="font-size: 10px; color: #FFD600;">AI · Gamifikasi</span>
        </div>
    </a>

    <!-- Planner Tugas Kelompok -->
    <a href="{{ route('teams.index') }}" class="menu-card">
        <i data-lucide="users" style="color: #00B0FF;"></i>
        <div>
            <h3>Planner Tugas Kelompok</h3>
            <p>Bagi tugas antar anggota dan lacak progres proyek kelompok.</p>
        </div>
        <div style="margin-top: auto;">
            <span style="font-size: 10px; color: #00B0FF;">Kolaborasi</span>
        </div>
    </a>

    <!-- Manajemen Mata Kuliah -->
    <a href="{{ route('subjects.index') }}" class="menu-card">
        <i data-lucide="book-open" style="color: var(--primary-purple);"></i>
        <div>
            <h3>Manajemen Mata Kuliah</h3>
            <p>Atur daftar mata kuliah, semester, dan label warna untuk setiap subjek.</p>
        </div>
        <div style="margin-top: auto;">
            <span style="font-size: 10px; color: var(--primary-purple);">Subjek · Semester</span>
        </div>
    </a>

    <!-- Catatan dari Rekaman -->
    <div class="menu-card" style="opacity: 0.6; cursor: not-allowed;">
        <i data-lucide="mic" style="color: var(--accent-red);"></i>
        <div>
            <h3>Catatan dari Rekaman</h3>
            <p>Rekam kuliah, otomatis transkrip dan buat catatan terstruktur.</p>
        </div>
        <div style="margin-top: auto;">
            <span class="badge" style="background: rgba(255,255,255,0.05); color: var(--text-muted); font-size: 8px;">COMING SOON</span>
        </div>
    </div>

    <!-- Template Dokumen -->
    <div class="menu-card" style="opacity: 0.6; cursor: not-allowed;">
        <i data-lucide="mail" style="color: #AA00FF;"></i>
        <div>
            <h3>Template Dokumen Cepat</h3>
            <p>Generate surat izin, proposal PKM, abstrak skripsi dengan AI.</p>
        </div>
        <div style="margin-top: auto;">
            <span class="badge" style="background: rgba(255,255,255,0.05); color: var(--text-muted); font-size: 8px;">COMING SOON</span>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 32px;">
    <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); text-align: center;">
        <i data-lucide="book-open" style="color: var(--primary-purple); width: 24px; height: 24px; margin-bottom: 8px;"></i>
        <h3 style="font-size: 24px; margin-bottom: 4px;">{{ $stats['subjects_count'] ?? 0 }}</h3>
        <p style="font-size: 12px; color: var(--text-muted);">Mata Kuliah</p>
    </div>
    <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); text-align: center;">
        <i data-lucide="calendar" style="color: var(--primary-green); width: 24px; height: 24px; margin-bottom: 8px;"></i>
        <h3 style="font-size: 24px; margin-bottom: 4px;">{{ $stats['deadlines_count'] ?? 0 }}</h3>
        <p style="font-size: 12px; color: var(--text-muted);">Deadline Aktif</p>
    </div>
    <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); text-align: center;">
        <i data-lucide="file-text" style="color: #00B0FF; width: 24px; height: 24px; margin-bottom: 8px;"></i>
        <h3 style="font-size: 24px; margin-bottom: 4px;">{{ $stats['documents_count'] ?? 0 }}</h3>
        <p style="font-size: 12px; color: var(--text-muted);">Dokumen Tersimpan</p>
    </div>
</div>
@endsection
