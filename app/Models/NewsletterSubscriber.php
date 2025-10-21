<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ============================================
// NEWSLETTER SUBSCRIBER MODEL
// ============================================

class NewsletterSubscriber extends Model
{
    use HasFactory;

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

    // --------------------------------------------
    // STATUS CONSTANTS
    // --------------------------------------------

    public const STATUS_SUBSCRIBED   = 'subscribed';
    public const STATUS_UNSUBSCRIBED = 'unsubscribed';

    // --------------------------------------------
    // BOOT (hooks)
    // --------------------------------------------

    protected static function booted()
    {
        // Normalize email to lowercase before saving
        static::saving(function ($subscriber) {
            if (!empty($subscriber->email)) {
                $subscriber->email = strtolower(trim($subscriber->email));
            }
        });
    }

    // --------------------------------------------
    // SCOPES
    // --------------------------------------------

    /**
     * Scope only active subscribers
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_SUBSCRIBED);
    }

    /**
     * Scope unsubscribed users
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', self::STATUS_UNSUBSCRIBED);
    }

    /**
     * Find by email
     */
    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', strtolower(trim($email)));
    }

    /**
     * Order by most recent subscription
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('subscribed_at');
    }

    // --------------------------------------------
    // HELPERS
    // --------------------------------------------

    /**
     * Subscribe (safe and idempotent)
     */
    public static function subscribe(string $email): self
    {
        $subscriber = static::firstOrNew(['email' => strtolower(trim($email))]);

        $subscriber->status = self::STATUS_SUBSCRIBED;
        $subscriber->subscribed_at = now();
        $subscriber->unsubscribed_at = null;
        $subscriber->save();

        return $subscriber;
    }

    /**
     * Unsubscribe user
     */
    public function unsubscribe(): void
    {
        if ($this->status !== self::STATUS_UNSUBSCRIBED) {
            $this->update([
                'status' => self::STATUS_UNSUBSCRIBED,
                'unsubscribed_at' => now(),
            ]);
        }
    }

    /**
     * Resubscribe user
     */
    public function resubscribe(): void
    {
        if ($this->status !== self::STATUS_SUBSCRIBED) {
            $this->update([
                'status' => self::STATUS_SUBSCRIBED,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        }
    }

    /**
     * Check if user is currently subscribed
     */
    public function isSubscribed(): bool
    {
        return $this->status === self::STATUS_SUBSCRIBED;
    }

    /**
     * Check if user has unsubscribed
     */
    public function isUnsubscribed(): bool
    {
        return $this->status === self::STATUS_UNSUBSCRIBED;
    }
}
