<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ============================================
// NEWSLETTER SUBSCRIBER MODEL
// ============================================

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'status',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    const STATUS_SUBSCRIBED = 'subscribed';
    const STATUS_UNSUBSCRIBED = 'unsubscribed';

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_SUBSCRIBED);
    }

    // ============================================
    // HELPERS
    // ============================================

    public function unsubscribe(): void
    {
        $this->update([
            'status' => self::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
        ]);
    }

    public function resubscribe(): void
    {
        $this->update([
            'status' => self::STATUS_SUBSCRIBED,
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
        ]);
    }

    public function isSubscribed(): bool
    {
        return $this->status === self::STATUS_SUBSCRIBED;
    }
}
