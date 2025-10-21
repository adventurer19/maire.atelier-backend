<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ============================================
// WISHLIST ITEM MODEL (supports user & guest)
// ============================================

class WishlistItem extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'token', // guest wishlist token
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'variant_id' => 'integer',
    ];

    /**
     * Enable timestamps (created_at / updated_at)
     */
    public $timestamps = true;

    // -------------------------------------------------------------------------
    // 🔗 RELATIONS
    // -------------------------------------------------------------------------

    /**
     * The user who owns this wishlist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The product added to wishlist.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Product variant (if applicable).
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    /**
     * Scope for items belonging to a given user ID.
     */
    public function scopeForUser($query, ?int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for items belonging to a given guest token.
     */
    public function scopeForToken($query, ?string $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Unified scope — get wishlist items by user or guest.
     */
    public function scopeForOwner($query, ?int $userId, ?string $token)
    {
        return $query
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId && $token, fn($q) => $q->where('token', $token));
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Determine if this item has a variant.
     */
    public function hasVariant(): bool
    {
        return !is_null($this->variant_id);
    }

    /**
     * Get display name (product + variant if exists)
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product?->name ?? 'Unknown Product';
        if ($this->variant) {
            $name .= ' - ' . $this->variant->getVariantName();
        }
        return $name;
    }
}
