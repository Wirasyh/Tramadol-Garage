@extends('layouts.garage')

@section('title', 'Masuk | Tramadol Garage')

@section('content')
    <section class="auth-wrap">
        <div class="auth-visual">
            <div><span class="eyebrow">Teman perjalananmu</span><h1>Kendaraan terawat, hati lebih tenang.</h1><p>Masuk untuk melanjutkan bersama RodaKita Garage.</p></div>
        </div>
        <div class="auth-panel">
            <form class="auth-form" method="POST" action="{{ route('login.store') }}">
                @csrf
                <h2>Selamat datang</h2>
                <p class="auth-subtitle">Masuk ke akun Tramadol Garage.</p>
                @if ($errors->any())
                    <div class="form-error" role="alert">{{ $errors->first() }}</div>
                @endif
                <div class="form-field">
                    <label for="email">Alamat email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
                <div class="form-field">
                    <label for="password">Kata sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                </div>
                <label class="remember-row"><input name="remember" type="checkbox" value="1"> Ingat saya di perangkat ini</label>
                <button class="button button-dark form-submit" type="submit">Masuk ke akun <span aria-hidden="true">→</span></button>
                <p class="form-note">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </form>
        </div>
    </section>
@endsection
<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
</div>
