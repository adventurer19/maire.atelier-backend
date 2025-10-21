<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'token', // guest cart token (for anonymous carts)
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];

    /**
     * Eager-loaded relations.
     */
    protected $with = ['product', 'variant'];

    // -------------------------------------------------------------------------
    // 🧩 RELATIONS
    // -------------------------------------------------------------------------

    /**
     * The user who owns this cart item (nullable for guests).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The product for this cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The product variant (if any).
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // -------------------------------------------------------------------------
    // 🧮 COMPUTED ATTRIBUTES
    // -------------------------------------------------------------------------

    /**
     * Get the effective price (variant or base product).
     */
    public function getPriceAttribute(): float
    {
        // if price is already stored, prefer it
        return $this->attributes['price'] ?? ($this->variant?->price ?? $this->product->price);
    }

    /**
     * Calculate the subtotal for this cart item.
     */
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Check if the product/variant has enough stock.
     */
    public function hasEnoughStock(): bool
    {
        $stock = $this->variant?->stock ?? $this->product->stock;
        return $stock >= $this->quantity;
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    /**
     * Scope for a specific authenticated user.
     */
    public function scopeForUser($query, ?int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for a specific guest token.
     */
    public function scopeForToken($query, ?string $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Scope to get items for either user or guest.
     * (Unified entry point for cart retrieval)
     */
    public function scopeForOwner($query, ?int $userId, ?string $token)
    {
        return $query
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId && $token, fn($q) => $q->where('token', $token));
    }
}
