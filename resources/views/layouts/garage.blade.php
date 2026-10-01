<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Servis motor dan mobil yang jujur, rapi, dan tepat waktu di Tramadol Garage.">
    <title>@yield('title', 'Tramadol Garage | Bengkel Motor & Mobil')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Tramadol Garage, beranda">
                <span class="brand-mark" aria-hidden="true">TK</span>
                <span><span class="brand-name">TRAMADOL GARAGE</span><span class="brand-sub">MOTOR · MOBIL · DETAILING</span></span>
            </a>
            @if (request()->routeIs('home'))
                <nav class="main-nav" aria-label="Navigasi utama">
                    <a href="#layanan">Layanan</a>
                    <a href="#tentang">Tentang kami</a>
                    <a href="#kontak">Kontak</a>
                </nav>
            @else
                <nav class="main-nav" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}">Beranda</a>
                </nav>
            @endif
            <div class="header-actions">
                @auth
                    <a class="header-link" href="{{ route('dashboard') }}">Akun saya</a>
                    <form class="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button" type="submit">Keluar</button>
                    </form>
                @else
                    <a class="header-link" href="{{ route('login') }}">Masuk</a>
                    <a class="button" href="{{ route('register') }}">Buat akun</a>
                @endauth
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
