<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        Gate::authorize('manage-bookings');

        return view('admin.bookings.index', [
            'bookings' => Booking::with(['user', 'service'])->latest()->paginate(15),
            'statuses' => Booking::STATUSES,
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        Gate::authorize('manage-bookings');

        $validated = $request->validate([
            'status' => ['required', Rule::in(Booking::STATUSES)],
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking berhasil diperbarui.');
    }
}
