@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Ringkas Materi</h1>
</div>

<div class="summary-container" style="margin-bottom: 24px;">
    <h3 style="font-size: 18px; margin-bottom: 16px;">Unggah Materi Kuliah</h3>
    
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">PILIH MATA KULIAH</label>
            <select name="subject_id" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;" required>
                <option value="">-- Pilih MK --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">FILE DOKUMEN (PDF/DOCX)</label>
            <div style="background: rgba(124, 77, 255, 0.05); border: 2px dashed var(--border-color); border-radius: 20px; padding: 40px; text-align: center; cursor: pointer;" onclick="document.getElementById('file-input').click()">
                <i data-lucide="file-up" style="width: 32px; height: 32px; color: var(--primary-purple); margin-bottom: 12px;"></i>
                <p id="file-name" style="font-size: 13px; color: var(--text-muted);">Klik untuk pilih file atau drag & drop</p>
                <input type="file" id="file-input" name="file" style="display: none;" onchange="document.getElementById('file-name').innerText = this.files[0].name" required>
            </div>
        </div>

        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="is_lab" value="1" id="is_lab">
            <label for="is_lab" style="font-size: 13px;">Dokumen Praktikum / Lab?</label>
        </div>

        <button type="submit" style="width: 100%; background: var(--primary-purple); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple);">
            UNGGAH & PROSES AI
        </button>
    </form>
</div>

<div style="background: var(--card-bg); border-radius: 20px; padding: 24px; border: 1px solid var(--border-color);">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i data-lucide="info" style="color: var(--primary-green); width: 18px;"></i>
        <h4 style="font-size: 15px; font-weight: 600;">Cara Kerja</h4>
    </div>
    <ul style="font-size: 12px; color: var(--text-muted); line-height: 1.6; padding-left: 16px;">
        <li>Upload materi kuliah Anda dalam format PDF atau DOCX.</li>
        <li>AI Siramen akan mengekstrak poin-poin penting secara otomatis.</li>
        <li>Sistem akan mengukur probabilitas materi ini keluar saat ujian.</li>
        <li>Hasil ringkasan dapat diekspor menjadi catatan belajar.</li>
    </ul>
</div>
@endsection
