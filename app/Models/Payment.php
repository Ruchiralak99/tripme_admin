<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'payment_reference',
        'booking_id',
        'booking_type',
        'amount',
        'payment_method',
        'payment_type',
        'reference_number',
        'payment_slip_path',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_reference)) {
                $payment->payment_reference = 'PAY-' . strtoupper(Str::random(8));
            }
        });
    }

    public function booking()
    {
        return $this->belongsTo(RideBooking::class, 'booking_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'verified' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    protected $table = 'payments';

}
