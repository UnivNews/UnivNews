<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Manually define created_at (no updated_at per spec)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
