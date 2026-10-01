<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('manage-services');

        return view('admin.services.index', [
            'services' => Service::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('manage-services');

        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('manage-services');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'is_active' => ['boolean'],
        ]);

        Service::create([
            ...$validated,
            'slug' => Str::slug($validated['name']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        Gate::authorize('manage-services');

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        Gate::authorize('manage-services');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'is_active' => ['boolean'],
        ]);

        $service->update([
            ...$validated,
            'slug' => Str::slug($validated['name']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        Gate::authorize('manage-services');

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
