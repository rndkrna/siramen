@extends('layouts.app', ['title' => 'Login - Siramen', 'header' => 'Selamat Datang'])

@section('content')
<div style="max-width: 400px; margin: 60px auto; padding: 40px; background: var(--card-bg); border-radius: 30px; border: 1px solid var(--border-color); box-shadow: 0 20px 40px rgba(0,0,0,0.4); text-align: center;">
    <div style="width: 64px; height: 64px; background: rgba(124, 77, 255, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
        <i data-lucide="graduation-cap" style="color: var(--primary-purple); width: 32px; height: 32px;"></i>
    </div>
    
    <h2 style="font-size: 24px; margin-bottom: 8px;">Siramen</h2>
    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 32px;">Masuk untuk menghemat waktu belajarmu.</p>

    <form action="{{ route('login') }}" method="POST" style="text-align: left;">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Email Address</label>
            <div style="position: relative;">
                <i data-lucide="mail" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; color: var(--text-muted);"></i>
                <input type="email" name="email" placeholder="nama@kampus.ac.id" style="width: 100%; background: #1A1A1A; border: 1px solid var(--border-color); color: white; padding: 12px 12px 12px 40px; border-radius: 12px; font-size: 14px; outline: none;" required>
            </div>
            @error('email') <p style="color: var(--accent-red); font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Password</label>
            <div style="position: relative;">
                <i data-lucide="lock" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; color: var(--text-muted);"></i>
                <input type="password" name="password" placeholder="••••••••" style="width: 100%; background: #1A1A1A; border: 1px solid var(--border-color); color: white; padding: 12px 12px 12px 40px; border-radius: 12px; font-size: 14px; outline: none;" required>
            </div>
        </div>

        <button type="submit" style="width: 100%; background: var(--primary-purple); color: white; border: none; padding: 16px; border-radius: 16px; font-weight: 700; font-size: 15px; cursor: pointer; box-shadow: var(--shadow-purple); transition: transform 0.2s;">
            MASUK SEKARANG
        </button>
    </form>

    <p style="font-size: 13px; color: var(--text-muted); margin-top: 24px;">
        Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary-purple); text-decoration: none; font-weight: 600;">Daftar Gratis</a>
    </p>
</div>
@endsection
