<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

// ============================================
// REVIEW MODEL
// ============================================

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope only approved reviews
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope only verified purchase reviews
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope the most recent reviews
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Scope for product reviews only
     */
    public function scopeForProduct(Builder $query, int $productId): Builder
    {
        return $query->where('product_id', $productId);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Approve a review
     */
    public function approve(): void
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * Disapprove a review
     */
    public function disapprove(): void
    {
        $this->update(['is_approved' => false]);
    }

    /**
     * Increment helpful vote count
     */
    public function incrementHelpful(): void
    {
        $this->increment('helpful_count');
    }

    /**
     * Get formatted review summary
     */
    public function getSummary(): string
    {
        return "{$this->title} ({$this->rating}/5)";
    }

    /**
     * Check if review is visible (approved)
     */
    public function isVisible(): bool
    {
        return $this->is_approved === true;
    }

    /**
     * Check if review was left by a verified buyer
     */
    public function isVerified(): bool
    {
        return $this->is_verified_purchase === true;
    }

    /**
     * Get review author name (fallback for guests)
     */
    public function getAuthorName(): string
    {
        return $this->user?->name ?? __('Guest');
    }
}
