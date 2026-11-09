<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'price_per_night',
        'capacity', 'description', 'image', 'is_available',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /** Only rooms that can be booked. */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Rooms with no active booking overlapping [$checkIn, $checkOut).
     * Overlap rule: existing.check_in < new.check_out AND existing.check_out > new.check_in
     */
    public function scopeFreeBetween($query, string $checkIn, string $checkOut)
    {
        return $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->where('status', '!=', 'cancelled')
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });
    }

    /** Works for both full URLs (seeded photos) and uploaded files. */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return 'https://placehold.co/800x500?text=No+Image';
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : Storage::url($this->image);
    }
}
