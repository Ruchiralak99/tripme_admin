<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $fillable = [
        'name',
        'overview',
        'passenger_seats',
        'images',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
        'passenger_seats' => 'integer'
    ];

     protected $table = 'aircrafts';
}
