<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Siramen') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/siramen.css') }}">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i data-lucide="graduation-cap" style="color: white; width: 24px; height: 24px;"></i>
                <h1 style="margin-bottom: 0;">{{ $header ?? 'Penghemat Waktu Mahasiswa' }}</h1>
            </div>
            <a href="{{ route('profile') }}" style="width: 32px; height: 32px; background: #2A2A2A; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid var(--border-color); text-decoration: none;">
                <i data-lucide="user" style="width: 18px; height: 18px; color: var(--text-muted);"></i>
            </a>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div id="alert-success" style="background: rgba(0, 200, 83, 0.1); border: 1px solid #00C853; color: #00C853; padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="check-circle" style="width: 18px;"></i>
                {{ session('success') }}
            </div>
            <script>setTimeout(() => { document.getElementById('alert-success').style.display = 'none'; }, 5000);</script>
        @endif

        @if(session('error'))
            <div id="alert-error" style="background: rgba(255, 82, 82, 0.1); border: 1px solid var(--accent-red); color: var(--accent-red); padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="alert-circle" style="width: 18px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="active-pill">
                    <i data-lucide="layout-grid"></i>
                    <span>Beranda</span>
                </div>
            @else
                <i data-lucide="layout-grid"></i>
                <span>Beranda</span>
            @endif
        </a>
        <a href="{{ route('deadlines.index') }}" class="nav-item {{ request()->routeIs('deadlines.*') ? 'active' : '' }}">
            <i data-lucide="calendar"></i>
            <span>Tugas</span>
        </a>
        <a href="#" class="nav-item">
            <i data-lucide="message-square"></i>
            <span>AI Chat</span>
        </a>
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i data-lucide="user"></i>
            <span>Profil</span>
        </a>
    </nav>

    <!-- Lucide Init -->
    <script>
      lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>
