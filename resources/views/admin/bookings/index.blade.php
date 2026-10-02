@extends('layouts.garage')

@section('title', 'Kelola booking | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
                <div>
                    <span class="section-kicker">Admin</span>
                    <h1 style="margin:10px 0 0;">Kelola booking</h1>
                </div>
                <a class="button button-outline" href="{{ route('admin.services.index') }}">Kelola layanan</a>
            </div>

            @if (session('success'))
                <div class="form-error" style="border-left-color: var(--green); background:#edf9f1; color:#1f5d3d; margin-bottom:20px;">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="form-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <div style="display:grid; gap:16px;">
                @forelse ($bookings as $booking)
                    <article style="border:1px solid var(--line); background:var(--white); padding:24px; display:grid; gap:14px;">
                        <div style="display:flex; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                            <div>
                                <div style="font-size:12px; font-weight:700; letter-spacing:1.3px; color:var(--green); text-transform:uppercase;">{{ $booking->service->name }}</div>
                                <h2 style="margin:8px 0; font:700 24px var(--display);">{{ $booking->customer_name }}</h2>
                                <div style="color:var(--muted); font-size:13px;">{{ $booking->user->email }} · {{ $booking->phone }}</div>
                            </div>
                            <div style="color:var(--ink-soft); font-size:13px;">
                                <div>{{ $booking->vehicle_type }} · {{ $booking->plate_number }}</div>
                                <div style="margin-top:6px;">{{ $booking->preferred_date->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if ($booking->notes)
                            <p style="margin:0; color:var(--muted); line-height:1.7;">{{ $booking->notes }}</p>
                        @endif

                        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" style="display:flex; gap:12px; align-items:end; flex-wrap:wrap;">
                            @csrf
                            @method('PATCH')
                            <div class="form-field" style="min-width:200px; margin:0;">
                                <label for="status-{{ $booking->id }}">Status: {{ $booking->status }}</label>
                                <select id="status-{{ $booking->id }}" name="status" required style="width:100%; height:48px; padding:0 13px; border:1px solid #cbd3ca; border-radius:2px; background:var(--white);">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', $booking->status) === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="button button-dark" type="submit">Simpan status</button>
                        </form>
                    </article>
                @empty
                    <div class="form-error" style="margin:0;">Belum ada booking yang dibuat.</div>
                @endforelse
            </div>

            <div style="margin-top:24px;">{{ $bookings->links() }}</div>
        </div>
    </section>
@endsection
