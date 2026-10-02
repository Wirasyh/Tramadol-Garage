<?php

use App\Http\Controllers\Api\V1\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Api\V1\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('auth.login');

    Route::middleware('auth')->group(function (): void {
        Route::get('/auth/user', [AuthController::class, 'user'])->name('auth.user');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    });

    Route::middleware(['auth', 'can:manage-services'])->prefix('admin')->name('admin.')->group(function (): void {
        Route::apiResource('services', AdminServiceController::class)->except(['create', 'edit']);
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    });
});
