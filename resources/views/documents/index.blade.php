@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('dashboard') }}" style="color: white; background: var(--card-bg); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color);">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <h1 style="margin-bottom: 0;">Materi & Dokumen</h1>
    </div>
    <a href="{{ route('documents.create') }}" style="background: var(--primary-purple); color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-purple);">
        + UPLOAD BARU
    </a>
</div>

<div style="background: var(--card-bg); border-radius: 20px; border: 1px solid var(--border-color); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.02);">
                <th style="text-align: left; padding: 16px; color: var(--text-muted); font-weight: 600;">NAMA FILE</th>
                <th style="text-align: left; padding: 16px; color: var(--text-muted); font-weight: 600;">MATA KULIAH</th>
                <th style="text-align: center; padding: 16px; color: var(--text-muted); font-weight: 600;">STATUS AI</th>
                <th style="text-align: right; padding: 16px; color: var(--text-muted); font-weight: 600;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i data-lucide="file-text" style="width: 18px; color: var(--primary-purple);"></i>
                        <a href="{{ route('documents.show', $document) }}" style="color: white; font-weight: 600; text-decoration: none;">{{ $document->file_name }}</a>
                    </div>
                </td>
                <td style="padding: 16px; color: var(--text-muted);">{{ $document->subject->name }}</td>
                <td style="padding: 16px; text-align: center;">
                    @if($document->status === 'processing')
                        <span style="background: rgba(124, 77, 255, 0.1); color: var(--primary-purple); padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 700;">PROCESSING...</span>
                    @elseif($document->summary)
                        <span style="background: rgba(0, 230, 118, 0.1); color: var(--primary-green); padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 700;">TERINGKAS</span>
                    @else
                        <span style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 700;">BELUM DIPROSES</span>
                    @endif
                </td>
                <td style="padding: 16px; text-align: right;">
                    <div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
                        @if(!$document->summary)
                            <form action="{{ route('documents.summary.generate', $document) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" title="Ringkas dengan AI" style="background: rgba(124, 77, 255, 0.1); border: none; color: var(--primary-purple); cursor: pointer; padding: 6px; border-radius: 8px;"><i data-lucide="sparkles" style="width: 16px;"></i></button>
                            </form>
                        @else
                            <form action="{{ route('documents.quiz.generate', $document) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" title="Generate Kuis" style="background: rgba(0, 230, 118, 0.1); border: none; color: var(--primary-green); cursor: pointer; padding: 6px; border-radius: 8px;"><i data-lucide="zap" style="width: 16px;"></i></button>
                            </form>
                        @endif
                        
                        <a href="{{ route('documents.show', $document) }}" style="color: var(--text-muted);"><i data-lucide="eye" style="width: 16px;"></i></a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: transparent; border: none; color: var(--accent-red); cursor: pointer;"><i data-lucide="trash-2" style="width: 16px;"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 40px; text-align: center; color: var(--text-muted);">
                    Belum ada dokumen. Silakan unggah materi pertama Anda.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
