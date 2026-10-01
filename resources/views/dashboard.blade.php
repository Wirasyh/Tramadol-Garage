@extends('layouts.garage')

@section('title', 'Akun saya | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <span class="section-kicker">Akun Tramadol</span>
            <h1>Halo, {{ auth()->user()->name }}.</h1>
                <p>Akunmu sudah aktif. Jelajahi layanan motor dan mobil untuk menemukan perawatan yang sesuai kebutuhan kendaraanmu.</p>
            <div class="dashboard-actions">
                <a class="button button-dark" href="{{ route('home') }}#layanan">Lihat layanan <span aria-hidden="true">→</span></a>
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="button button-outline" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </section>
    <footer class="site-footer"><span>© {{ date('Y') }} Tramadol Garage</span><span>Jl. Industri Raya No. 18 · Senin–Sabtu, 08.00–20.00</span></footer>
        <footer class="site-footer"><span>© {{ date('Y') }} Tramadol Garage</span><span>Servis motor · Servis mobil · Perawatan berkala</span></footer>
@endsection
<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
</div>
