<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'boost_price_id',
        'duration_type',
        'duration_days',
        'price_paid',
        'start_date',
        'end_date',
        'slot_number',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boostPrice()
    {
        return $this->belongsTo(BoostPrice::class);
    }

    public function payments()
    {
        return $this->hasMany(BoostPayment::class);
    }
}
