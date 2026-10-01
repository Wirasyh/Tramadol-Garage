@extends('layouts.garage')

@section('title', 'Buat booking | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <span class="section-kicker">Booking</span>
            <h1 style="margin:10px 0 18px;">Jadwalkan servis</h1>

            @if ($errors->any())
                <div class="form-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('bookings.store') }}" style="display:grid; gap:18px; max-width:760px;">
                @csrf

                <div class="form-field">
                    <label for="service_id">Layanan</label>
                    <select id="service_id" name="service_id" required style="width:100%; height:48px; padding:0 13px; border:1px solid #cbd3ca; border-radius:2px; background:var(--white);">
                        <option value="">Pilih layanan</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} — Rp {{ number_format($service->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:18px;">
                    <div class="form-field">
                        <label for="customer_name">Nama pemesan</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name', auth()->user()->name) }}" required>
                    </div>
                    <div class="form-field">
                        <label for="phone">Nomor telepon</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:18px;">
                    <div class="form-field">
                        <label for="vehicle_type">Jenis kendaraan</label>
                        <select id="vehicle_type" name="vehicle_type" required style="width:100%; height:48px; padding:0 13px; border:1px solid #cbd3ca; border-radius:2px; background:var(--white);">
                            <option value="motor" {{ old('vehicle_type') === 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('vehicle_type') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="plate_number">Nomor plat</label>
                        <input id="plate_number" name="plate_number" type="text" value="{{ old('plate_number') }}" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="preferred_date">Tanggal preferensi</label>
                    <input id="preferred_date" name="preferred_date" type="date" value="{{ old('preferred_date') }}" required>
                </div>

                <div class="form-field">
                    <label for="notes">Catatan tambahan</label>
                    <textarea id="notes" name="notes" rows="4" style="width:100%; padding:12px 13px; border:1px solid #cbd3ca; border-radius:2px; resize:vertical;">{{ old('notes') }}</textarea>
                </div>

                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <button class="button button-dark form-submit" type="submit" style="width:auto;">Kirim booking</button>
                    <a class="button button-outline" href="{{ route('bookings.index') }}">Lihat daftar booking</a>
                </div>
            </form>
        </div>
    </section>
@endsection
