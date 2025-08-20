<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RideBooking extends Model
{
    protected $fillable = [
        'booking_reference',
        'ride_id',
        'city_id',
        'user_id',
        'full_name',
        'phone_number',
        'email',
        'quantity',
        'passengers',
        'base_price',
        'tax_amount',
        'subtotal',
        'promo_discount',
        'full_payment_discount',
        'total_amount',
        'payment_type',
        'paid_amount',
        'remaining_amount',
        'promo_code',
        'additional_notes',
        'status',
        'preferred_date',
        'confirmed_date'
    ];

    protected $casts = [
        'passengers' => 'array',
        'base_price' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'promo_discount' => 'decimal:2',
        'full_payment_discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'preferred_date' => 'datetime',
        'confirmed_date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'RB-' . strtoupper(Str::random(8));
            }
        });
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function city()
    {
        return $this->belongsTo(RideCity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'completed' => 'blue',
            default => 'gray'
        };
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->payment_type === 'tentative') {
            return 'No Payment Required';
        }

        if ($this->paid_amount >= $this->total_amount) {
            return 'Fully Paid';
        } elseif ($this->paid_amount > 0) {
            return 'Partially Paid';
        } else {
            return 'Unpaid';
        }
    }

    protected $table = 'rides_bookings';

}
