<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirTaxiBooking extends Model
{
    protected $fillable = [
        'user_id',
        'aircraft_id',
        'full_name',
        'phone_number',
        'tour_type',
        'start_point',
        'end_point',
        'booking_date',
        'booking_time',
        'passengers',
        'total_amount',
        'status',
        'is_active',
        'notes',
        'confirmed_at'
    ];

    protected $casts = [
        'passengers' => 'array',
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i',
        'confirmed_at' => 'datetime',
        'is_active' => 'boolean',
        'total_amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aircraft(): BelongsTo
    {
        return $this->belongsTo(Aircraft::class);
    }
}
