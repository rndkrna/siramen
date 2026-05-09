@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('deadlines.index') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Tambah Deadline</h1>
</div>

<div class="summary-container">
    <form action="{{ route('deadlines.store') }}" method="POST">
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

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">JUDUL TUGAS / DEADLINE</label>
            <input type="text" name="title" placeholder="Contoh: UTS Arsitektur Perangkat Lunak" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">TANGGAL & WAKTU</label>
                <input type="datetime-local" name="due_date" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;" required>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">PRIORITAS</label>
                <select name="priority" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;">
                    <option value="low">Rendah</option>
                    <option value="medium" selected>Sedang</option>
                    <option value="high">Tinggi (Mendesak)</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">KATEGORI</label>
            <select name="type" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;">
                <option value="Assignment">Tugas Biasa</option>
                <option value="UTS">UTS</option>
                <option value="Seminar">Seminar</option>
            </select>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">KETERANGAN TAMBAHAN</label>
            <textarea name="description" placeholder="Lokasi, Link LMS, atau catatan lainnya..." style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit; min-height: 80px;"></textarea>
        </div>

        <button type="submit" style="width: 100%; background: var(--primary-purple); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple);">
            TAMBAH DEADLINE
        </button>
    </form>
</div>
@endsection
