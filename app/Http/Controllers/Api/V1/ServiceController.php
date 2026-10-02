<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ServiceResource::collection(
            Service::query()->where('is_active', true)->orderBy('name')->paginate(15),
        );
    }

    public function show(Service $service): ServiceResource
    {
        abort_unless($service->is_active, 404);

        return new ServiceResource($service);
    }
}
