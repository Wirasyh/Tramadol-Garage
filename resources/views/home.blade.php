@extends('layouts.garage')

@section('title', 'Tramadol Garage | Bengkel Motor & Mobil Terpercaya')

@section('content')
    <section class="hero" id="tentang">
        <div class="hero-inner">
            <span class="eyebrow">Bengkel motor &amp; mobil · servis yang transparan</span>
            <h1>Rawat hari ini.<br><span>Jalan lebih jauh.</span></h1>
            <p class="hero-copy">Servis yang transparan, dikerjakan teknisi berpengalaman, dan dijelaskan sebelum kami mulai. Kendaraanmu aman, waktumu tetap terjaga.</p>
            <div class="hero-actions">
                <a class="button" href="#layanan">Cari layanan <span aria-hidden="true">↗</span></a>
                <a class="text-link" href="{{ route('register') }}">Buat akun <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="hero-note"><span class="status-dot" aria-hidden="true"></span><span>Perawatan motor &amp; mobil</span></div>
    </section>

    <section class="trust-strip" aria-label="Keunggulan bengkel">
        <div class="trust-item"><span class="trust-number">Terbuka</span><span class="trust-label">Estimasi sebelum pengerjaan</span></div>
        <div class="trust-item"><span class="trust-number">Terarah</span><span class="trust-label">Diagnosa sesuai kebutuhan</span></div>
        <div class="trust-item"><span class="trust-number">Lengkap</span><span class="trust-label">Motor dan mobil</span></div>
        <div class="trust-item"><span class="trust-number">Terjaga</span><span class="trust-label">Pemeriksaan sebelum diserahkan</span></div>
    </section>

    <section class="section" id="layanan">
        <div class="section-heading">
            <div><span class="section-kicker">Yang kami kerjakan</span><h2>Perawatan yang tepat. Tanpa tebak-tebakan.</h2></div>
            <p class="section-intro">Mulai dari servis berkala sampai kendaraan yang butuh perhatian ekstra, pilih perawatan sesuai kebutuhan kendaraanmu.</p>
        </div>

        <div class="service-grid">
            @forelse ($services as $service)
                <article class="service">
                    <span class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ strtoupper($service->category) }}</span>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>
                </article>
            @empty
                <article class="service">
                    <span class="service-number">01 / MOTOR</span>
                    <h3>Servis &amp; tune up</h3>
                    <p>Oli, rem, transmisi, injeksi, dan pemeriksaan rutin untuk perjalanan sehari-hari.</p>
                </article>
                <article class="service">
                    <span class="service-number">02 / MOBIL</span>
                    <h3>Mesin &amp; kaki-kaki</h3>
                    <p>Diagnosa menyeluruh, perawatan mesin, AC, spooring, dan balancing.</p>
                </article>
                <article class="service">
                    <span class="service-number">03 / DETAIL</span>
                    <h3>Detailing &amp; inspeksi</h3>
                    <p>Interior lebih segar, cat terawat, serta pemeriksaan sebelum perjalanan jauh.</p>
                </article>
            @endforelse
        </div>
    </section>

    <section class="booking-band" id="kontak">
        <div><h2>Suara mesin berubah? Mulai dengan konsultasi servis.</h2><p>Buat akun untuk melanjutkan, atau masuk jika sudah terdaftar.</p></div>
        <a class="button" href="{{ route('register') }}">Buat akun pelanggan <span aria-hidden="true">↗</span></a>
    </section>

    <footer class="site-footer"><span>© {{ date('Y') }} Tramadol Garage</span><span>Servis motor · Servis mobil · Perawatan berkala</span></footer>
@endsection
