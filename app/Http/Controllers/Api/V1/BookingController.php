<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BookingResource;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        return BookingResource::collection(
            Booking::query()
                ->with('service')
                ->whereBelongsTo($request->user())
                ->latest()
                ->paginate(15),
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => [
                'required',
                Rule::exists((new Service)->getTable(), 'id')->where('is_active', true),
            ],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'vehicle_type' => ['required', Rule::in(['motor', 'mobil'])],
            'plate_number' => ['required', 'string', 'max:20'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = Booking::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        return (new BookingResource($booking->load('service')))->response()->setStatusCode(201);
    }
}
