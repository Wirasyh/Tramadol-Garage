<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection(
            Booking::query()->with(['user', 'service'])->latest()->paginate(15),
        );
    }

    public function update(Request $request, Booking $booking): BookingResource
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Booking::STATUSES)],
        ]);

        $booking->update($validated);

        return new BookingResource($booking->load(['user', 'service']));
    }
}
