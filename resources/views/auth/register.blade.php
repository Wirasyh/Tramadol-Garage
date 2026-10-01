@extends('layouts.garage')

@section('title', 'Buat akun | Tramadol Garage')

@section('content')
    <section class="auth-wrap">
        <div class="auth-visual">
            <div><span class="eyebrow">Mulai dari sini</span><h1>Lebih dekat dengan perjalanan yang lancar.</h1><p>Buat akun untuk terhubung dengan layanan RodaKita Garage.</p></div>
        </div>
        <div class="auth-panel">
            <form class="auth-form" method="POST" action="{{ route('register.store') }}">
                @csrf
                <h2>Buat akun</h2>
                <p class="auth-subtitle">Isi data singkat untuk bergabung.</p>
                @if ($errors->any())
                    <div class="form-error" role="alert">{{ $errors->first() }}</div>
                @endif
                <div class="form-field">
                    <label for="name">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus>
                </div>
                <div class="form-field">
                    <label for="email">Alamat email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required>
                </div>
                <div class="form-field">
                    <label for="password">Kata sandi</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required>
                </div>
                <div class="form-field">
                    <label for="password_confirmation">Ulangi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required>
                </div>
                <button class="button button-dark form-submit" type="submit">Buat akun <span aria-hidden="true">→</span></button>
                <p class="form-note">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
            </form>
        </div>
    </section>
@endsection
<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
