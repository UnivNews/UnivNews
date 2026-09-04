<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoostPrice extends Model
{
    protected $fillable = [
        'duration_type',
        'duration_days',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
        'duration_days' => 'integer',
    ];
}
