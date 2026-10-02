<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ServiceResource::collection(Service::query()->orderBy('name')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['motor', 'mobil', 'detailing'])],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $service = Service::create([
            ...$validated,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return (new ServiceResource($service))->response()->setStatusCode(201);
    }

    public function show(Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }

    public function update(Request $request, Service $service): ServiceResource
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['sometimes', 'required', Rule::in(['motor', 'mobil', 'detailing'])],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'required', 'integer', 'min:0'],
            'duration_minutes' => ['sometimes', 'required', 'integer', 'min:15'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $service->update($validated);

        return new ServiceResource($service->refresh());
    }

    public function destroy(Service $service): JsonResponse
    {
        if ($service->bookings()->exists()) {
            return response()->json([
                'message' => 'Layanan tidak dapat dihapus karena sudah memiliki booking.',
            ], 409);
        }

        $service->delete();

        return response()->json(status: 204);
    }
}
