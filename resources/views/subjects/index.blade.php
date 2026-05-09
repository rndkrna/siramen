@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <h1 style="margin-bottom: 0;">Mata Kuliah</h1>
    </div>
    <a href="{{ route('subjects.create') }}" style="background: var(--primary-purple); color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-purple);">
        + TAMBAH MK
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
    @forelse($subjects as $subject)
    <div style="background: var(--card-bg); border-radius: 20px; padding: 20px; border: 1px solid var(--border-color); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 6px; height: 100%; background: {{ $subject->color_hex ?? 'var(--primary-purple)' }};"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
            <span style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Semester {{ $subject->semester ?? '?' }}</span>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('subjects.edit', $subject) }}" style="color: var(--text-muted);"><i data-lucide="edit-3" style="width: 14px;"></i></a>
            </div>
        </div>
        
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">{{ $subject->name }}</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div style="background: rgba(255,255,255,0.03); padding: 10px; border-radius: 12px; text-align: center;">
                <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">DOKUMEN</p>
                <h4 style="font-size: 16px; margin: 0;">{{ $subject->documents_count }}</h4>
            </div>
            <div style="background: rgba(255,255,255,0.03); padding: 10px; border-radius: 12px; text-align: center;">
                <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">DEADLINE</p>
                <h4 style="font-size: 16px; margin: 0;">{{ $subject->deadlines_count }}</h4>
            </div>
        </div>
        
        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
             <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: transparent; border: none; color: var(--accent-red); font-size: 11px; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                    <i data-lucide="trash-2" style="width: 12px;"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; background: var(--card-bg); border-radius: 20px; padding: 60px; text-align: center; border: 1px solid var(--border-color);">
        <i data-lucide="book-x" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
        <h3 style="color: var(--text-muted);">Belum ada mata kuliah</h3>
        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 24px;">Mulai dengan menambahkan mata kuliah semester ini.</p>
        <a href="{{ route('subjects.create') }}" style="background: var(--primary-purple); color: white; padding: 10px 24px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600;">TAMBAH SEKARANG</a>
    </div>
    @endforelse
</div>
@endsection
