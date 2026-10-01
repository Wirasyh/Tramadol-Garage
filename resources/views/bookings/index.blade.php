@extends('layouts.garage')

@section('title', 'Daftar booking | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
                <div>
                    <span class="section-kicker">Booking</span>
                    <h1 style="margin:10px 0 0;">Daftar booking</h1>
                </div>
                <a class="button button-dark" href="{{ route('bookings.create') }}">Buat booking baru</a>
            </div>

            @if (session('success'))
                <div class="form-error" style="border-left-color: var(--green); background:#edf9f1; color:#1f5d3d; margin-bottom:20px;">{{ session('success') }}</div>
            @endif

            <div style="display:grid; gap:16px;">
                @forelse ($bookings as $booking)
                    <article style="border:1px solid var(--line); background:var(--white); padding:24px; display:grid; gap:8px;">
                        <div style="display:flex; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                            <div>
                                <div style="font-size:12px; font-weight:700; letter-spacing:1.3px; color:var(--green); text-transform:uppercase;">{{ $booking->service->name }}</div>
                                <h3 style="margin:8px 0; font:700 24px var(--display);">{{ $booking->customer_name }}</h3>
                            </div>
                            <span style="padding:6px 10px; background:#eef7ef; color:#1d5d3a; border-radius:999px; font-size:12px; font-weight:700; text-transform:uppercase;">{{ $booking->status }}</span>
                        </div>
                        <div style="display:flex; gap:18px; flex-wrap:wrap; color:var(--muted); font-size:13px;">
                            <span>{{ $booking->vehicle_type }}</span>
                            <span>{{ $booking->plate_number }}</span>
                            <span>{{ $booking->preferred_date->format('d M Y') }}</span>
                        </div>
                        @if ($booking->notes)
                            <p style="margin:0; color:var(--muted); line-height:1.7;">{{ $booking->notes }}</p>
                        @endif
                    </article>
                @empty
                    <div class="form-error" style="margin:0;">Belum ada booking yang dibuat.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
