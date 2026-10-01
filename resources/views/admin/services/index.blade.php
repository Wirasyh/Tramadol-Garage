@extends('layouts.garage')

@section('title', 'Kelola layanan | Tramadol Garage')

@section('content')
    <section class="dashboard-main">
        <div class="dashboard-panel">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
                <div>
                    <span class="section-kicker">Admin</span>
                    <h1 style="margin:10px 0 0;">Kelola layanan</h1>
                </div>
                <a class="button button-dark" href="{{ route('admin.services.create') }}">Tambah layanan</a>
            </div>

            @if (session('success'))
                <div class="form-error" style="border-left-color: var(--green); background:#edf9f1; color:#1f5d3d; margin-bottom:20px;">{{ session('success') }}</div>
            @endif

            <div style="display:grid; gap:16px;">
                @foreach ($services as $service)
                    <article style="border:1px solid var(--line); background:var(--white); padding:24px; display:flex; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                        <div>
                            <div style="font-size:12px; text-transform:uppercase; letter-spacing:1.3px; color:var(--green); font-weight:700;">{{ $service->category }}</div>
                            <h3 style="margin:10px 0 8px; font:700 26px var(--display);">{{ $service->name }}</h3>
                            <p style="margin:0; color:var(--muted); line-height:1.7;">{{ $service->description }}</p>
                            <div style="margin-top:12px; display:flex; gap:16px; flex-wrap:wrap; color:var(--ink-soft); font-size:13px;">
                                <span>Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                <span>{{ $service->duration_minutes }} menit</span>
                                <span>{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        </div>
                        <div style="display:flex; gap:10px; align-items:flex-start;">
                            <a class="button button-outline" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                                @csrf
                                @method('DELETE')
                                <button class="button" type="submit" style="background:#e97052; color:white;">Hapus</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
