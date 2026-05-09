<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Siramen') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Instrument Sans', sans-serif; background-color: #f9fafb; color: #1f2937; }
            .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
            header { background-color: white; border-bottom: 1px solid #e5e7eb; padding: 20px 0; }
            .navbar { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
            .nav-links { display: flex; gap: 20px; list-style: none; }
            .nav-links a { text-decoration: none; color: #374151; font-weight: 500; }
            .nav-links a:hover { color: #1f2937; }
            .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-block; }
            .btn-primary { background-color: #3b82f6; color: white; }
            .btn-primary:hover { background-color: #2563eb; }
            .btn-secondary { background-color: #6b7280; color: white; }
            .btn-danger { background-color: #ef4444; color: white; }
            .table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
            .table th { background-color: #f3f4f6; padding: 12px; text-align: left; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
            .table td { padding: 12px; border-bottom: 1px solid #e5e7eb; }
            .table tr:hover { background-color: #f9fafb; }
            .form-group { margin-bottom: 20px; }
            .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
            .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; }
            .form-group textarea { resize: vertical; }
            .alert { padding: 12px 16px; border-radius: 4px; margin-bottom: 20px; }
            .alert-success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
            .alert-error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
            .alert-info { background-color: #dbeafe; color: #0c4a6e; border: 1px solid #bfdbfe; }
        </style>
    @endif

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <a href="{{ route('dashboard') }}" style="font-size: 24px; font-weight: bold; color: #3b82f6; text-decoration: none;">
                    Siramen
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('subjects.index') }}">Subjects</a></li>
                <li><a href="{{ route('deadlines.index') }}">Deadlines</a></li>
                <li><a href="{{ route('documents.index') }}">Documents</a></li>
                <li><a href="{{ route('quizzes.index') }}">Quizzes</a></li>
                <li><a href="{{ route('activity-logs.index') }}">Logs</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #374151; cursor: pointer; font-weight: 500;">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Validation Error!</strong>
                    <ul style="margin-top: 8px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer style="background-color: white; border-top: 1px solid #e5e7eb; padding: 20px; text-align: center; color: #6b7280; margin-top: 40px;">
        <p>&copy; {{ date('Y') }} Siramen - Learning Management System</p>
    </footer>

    @stack('scripts')
</body>
</html>
