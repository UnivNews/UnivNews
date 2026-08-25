<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    const STATUS_DRAFT            = 'draft';
    const STATUS_PENDING_REVIEW    = 'pending_review';
    const STATUS_AWAITING_PAYMENT  = 'awaiting_payment';
    const STATUS_PUBLISHED         = 'published';
    const STATUS_REJECTED          = 'rejected';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'status',
        'admin_notes',
        'published_at',
        'views_count',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function boosts(): HasMany
    {
        return $this->hasMany(Boost::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING_REVIEW);
    }

    public function scopeAwaitingPayment(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AWAITING_PAYMENT);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPendingReview(): bool
    {
        return $this->status === self::STATUS_PENDING_REVIEW;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isAwaitingPayment(): bool
    {
        return $this->status === self::STATUS_AWAITING_PAYMENT;
    }

    public function isBoosted(): bool
    {
        $today = now()->toDateString();

        if ($this->relationLoaded('boosts')) {
            return $this->boosts->contains(function ($boost) use ($today) {
                $startDate = $boost->start_date ? (\is_string($boost->start_date) ? $boost->start_date : $boost->start_date->toDateString()) : null;
                $endDate = $boost->end_date ? (\is_string($boost->end_date) ? $boost->end_date : $boost->end_date->toDateString()) : null;

                return $boost->status === 'active'
                    && ($startDate === null || $startDate <= $today)
                    && ($endDate === null || $endDate >= $today);
            });
        }

        return $this->boosts()
            ->where('status', 'active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();
    }
}

