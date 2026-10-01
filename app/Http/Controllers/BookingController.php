<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        if (auth()->user()->isAdmin()) {
            $bookings = Booking::with(['user', 'service'])->latest()->get();
        } else {
            $bookings = Booking::with('service')->where('user_id', auth()->id())->latest()->get();
        }

        return view('bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function create(): View
    {
        return view('bookings.create', [
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'vehicle_type' => ['required', 'in:motor,mobil'],
            'plate_number' => ['required', 'string', 'max:20'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Booking::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat.');
    }
}
