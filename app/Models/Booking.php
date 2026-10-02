<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'customer_name',
        'phone',
        'vehicle_type',
        'plate_number',
        'preferred_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
