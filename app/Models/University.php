<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function articles()
    {
        return $this->hasManyThrough(Article::class, User::class);
    }
}
