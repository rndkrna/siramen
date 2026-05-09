@extends('layouts.app', ['title' => 'Profil Saya', 'header' => 'Profil Saya'])

@section('content')
<div style="background: var(--card-bg); border-radius: 30px; padding: 40px; border: 1px solid var(--border-color); text-align: center; margin-bottom: 24px;">
    <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 20px;">
        <div style="width: 100%; height: 100%; background: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid var(--primary-purple);">
            <i data-lucide="user" style="width: 48px; height: 48px; color: var(--text-muted);"></i>
        </div>
        <div style="position: absolute; bottom: 0; right: 0; background: var(--primary-purple); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--card-bg);">
            <i data-lucide="camera" style="width: 16px; color: white;"></i>
        </div>
    </div>

    <h2 style="font-size: 20px; margin-bottom: 4px;">{{ $user->full_name }}</h2>
    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">{{ $user->email }}</p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; text-align: left;">
        <div style="background: rgba(255,255,255,0.03); padding: 16px; border-radius: 16px; border: 1px solid var(--border-color);">
            <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">RANKING</p>
            <p style="font-size: 16px; font-weight: 700; color: #FFD600;">Scholar Elite</p>
        </div>
        <div style="background: rgba(255,255,255,0.03); padding: 16px; border-radius: 16px; border: 1px solid var(--border-color);">
            <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">POIN BELAJAR</p>
            <p style="font-size: 16px; font-weight: 700; color: var(--primary-green);">2,450 XP</p>
        </div>
    </div>
</div>

<div style="background: var(--card-bg); border-radius: 24px; padding: 24px; border: 1px solid var(--border-color); margin-bottom: 80px;">
    <h4 style="font-size: 15px; margin-bottom: 20px;">Pengaturan Akun</h4>
    
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-bottom: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i data-lucide="bell" style="width: 18px; color: var(--text-muted);"></i>
                <span style="font-size: 14px;">Notifikasi</span>
            </div>
            <i data-lucide="chevron-right" style="width: 16px; color: var(--text-muted);"></i>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-bottom: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i data-lucide="shield-check" style="width: 18px; color: var(--text-muted);"></i>
                <span style="font-size: 14px;">Privasi & Keamanan</span>
            </div>
            <i data-lucide="chevron-right" style="width: 16px; color: var(--text-muted);"></i>
        </div>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 12px;">
            @csrf
            <button type="submit" style="width: 100%; background: rgba(255, 82, 82, 0.1); color: var(--accent-red); border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i data-lucide="log-out" style="width: 18px;"></i>
                KELUAR DARI AKUN
            </button>
        </form>
    </div>
</div>
@endsection
