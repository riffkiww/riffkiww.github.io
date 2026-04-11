<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Klinik Care' }}</title>
    <link rel="stylesheet" href="{{ asset('clinic.css') }}">
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="app-body">
    <div class="app-backdrop app-backdrop-a"></div>
    <div class="app-backdrop app-backdrop-b"></div>

    <div class="app-shell">
        <header class="topbar">
            <div>
                <div class="brand-kicker">Sistem Klinik Internal</div>
                <a href="{{ route('dashboard') }}" class="brand-link">Klinik Care</a>
            </div>

            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('patients.index') }}" @class(['nav-link', 'active' => request()->routeIs('patients.*')])>Data Pasien</a>
            </nav>
        </header>

        <main class="page">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa input Anda.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>