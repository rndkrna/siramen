@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('teams.index') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Buat Kelompok Baru</h1>
</div>

<div class="summary-container">
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">NAMA PROYEK / KELOMPOK</label>
            <input type="text" name="name" placeholder="Contoh: Pengembangan App Edukasi" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;" required>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">DESKRIPSI TUGAS</label>
            <textarea name="description" placeholder="Apa yang sedang dikerjakan tim ini?" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit; min-height: 100px;"></textarea>
        </div>

        <button type="submit" style="width: 100%; background: var(--primary-purple); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple);">
            SIMPAN & LANJUTKAN
        </button>
    </form>
</div>
@endsection
