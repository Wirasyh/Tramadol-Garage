<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $service): void {
            if (! $service->isDirty('name') && filled($service->slug)) {
                return;
            }

            $baseSlug = Str::slug($service->name) ?: 'service';
            $slug = $baseSlug;
            $suffix = 2;

            while (static::query()
                ->where('slug', $slug)
                ->when($service->exists, fn ($query) => $query->whereKeyNot($service->getKey()))
                ->exists()) {
                $slug = $baseSlug.'-'.$suffix;
                $suffix++;
            }

            $service->slug = $slug;
        });
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
