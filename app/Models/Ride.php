<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_lkr',
        'tax_percentage',
        'discount_percentage',
        'regular_value',
        'duration',
        'passenger_capacity',
        'image_path',
        'status'
    ];

    protected $casts = [
        'price_lkr' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'regular_value' => 'decimal:2',
        'passenger_capacity' => 'integer'
    ];
}
