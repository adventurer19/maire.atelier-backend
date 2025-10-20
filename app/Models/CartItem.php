<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected $with = ['product', 'variant'];

    /**
     * Get the user that owns the cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant for this cart item (if any)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Calculate the subtotal for this cart item
     */
    public function getSubtotalAttribute(): float
    {
        $price = $this->variant?->price ?? $this->product->price;
        return $price * $this->quantity;
    }

    /**
     * Get the item price (variant or product)
     */
    public function getPriceAttribute(): float
    {
        return $this->variant?->price ?? $this->product->price;
    }

    /**
     * Check if product has enough stock
     */
    public function hasEnoughStock(): bool
    {
        $stock = $this->variant?->stock ?? $this->product->stock;
        return $stock >= $this->quantity;
    }

    /**
     * Scope to filter by session ID
     */
    public function scopeForSession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope to filter by user ID
     */
    public function scopeForUser($query, ?int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
