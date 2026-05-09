@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('subjects.index') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
    </a>
    <h1 style="margin-bottom: 0;">Tambah Mata Kuliah</h1>
</div>

<div class="summary-container" style="max-width: 600px;">
    <form method="POST" action="{{ route('subjects.store') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">NAMA MATA KULIAH</label>
            <input type="text" name="name" required placeholder="Contoh: Algoritma & Struktur Data" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">SEMESTER</label>
                <select name="semester" style="width: 100%; background: #222; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 12px; font-family: inherit; appearance: none;">
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}">Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">LABEL WARNA</label>
                <input type="color" name="color_hex" value="#7C4DFF" style="width: 100%; background: #222; border: 1px solid var(--border-color); height: 45px; padding: 4px; border-radius: 12px; cursor: pointer;">
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; gap: 12px;">
            <button type="submit" style="flex: 1; background: var(--primary-purple); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: var(--shadow-purple);">
                SIMPAN MATA KULIAH
            </button>
            <a href="{{ route('subjects.index') }}" style="background: rgba(255,255,255,0.05); color: white; text-decoration: none; padding: 14px 24px; border-radius: 12px; font-weight: 600; border: 1px solid var(--border-color);">
                BATAL
            </a>
        </div>
    </form>
</div>
@endsection