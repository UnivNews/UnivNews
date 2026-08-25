<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoostPayment extends Model
{
    protected $fillable = [
        'boost_id',
        'user_id',
        'mayar_transaction_id',
        'amount',
        'status',
    ];

    public function boost()
    {
        return $this->belongsTo(Boost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
