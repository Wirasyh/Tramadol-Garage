@extends('layouts.garage')

@section('title', 'Tambah layanan | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <span class="section-kicker">Admin</span>
            <h1 style="margin:10px 0 20px;">Tambah layanan</h1>

            @if ($errors->any())
                <div class="form-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.services.store') }}" style="display:grid; gap:18px; max-width:680px;">
                @csrf

                <div class="form-field">
                    <label for="name">Nama layanan</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                </div>

                <div class="form-field">
                    <label for="category">Kategori</label>
                    <select id="category" name="category" required style="width:100%; height:48px; padding:0 13px; border:1px solid #cbd3ca; border-radius:2px; background:var(--white);">
                        <option value="motor" {{ old('category') === 'motor' ? 'selected' : '' }}>Motor</option>
                        <option value="mobil" {{ old('category') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="detailing" {{ old('category') === 'detailing' ? 'selected' : '' }}>Detailing</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" style="width:100%; padding:12px 13px; border:1px solid #cbd3ca; border-radius:2px; resize:vertical;">{{ old('description') }}</textarea>
                </div>

                <div style="display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:18px;">
                    <div class="form-field">
                        <label for="price">Harga</label>
                        <input id="price" name="price" type="number" min="0" value="{{ old('price') }}" required>
                    </div>
                    <div class="form-field">
                        <label for="duration_minutes">Durasi (menit)</label>
                        <input id="duration_minutes" name="duration_minutes" type="number" min="15" value="{{ old('duration_minutes') }}" required>
                    </div>
                </div>

                <label class="remember-row">
                    <input name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    Aktifkan layanan ini
                </label>

                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <button class="button button-dark form-submit" type="submit" style="width:auto;">Simpan layanan</button>
                    <a class="button button-outline" href="{{ route('admin.services.index') }}">Kembali</a>
                </div>
            </form>
        </div>
    </section>
@endsection
