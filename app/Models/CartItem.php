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

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Get item subtotal (price * quantity)
     */
    public function getSubtotal(): float
    {
        $price = $this->variant
            ? $this->variant->getFinalPrice()
            : $this->product->price;

        return $price * $this->quantity;
    }

    /**
     * Get unit price
     */
    public function getUnitPrice(): float
    {
        return $this->variant
            ? $this->variant->getFinalPrice()
            : $this->product->price;
    }

    /**
     * Check if item is in stock
     */
    public function isInStock(): bool
    {
        if ($this->variant) {
            return $this->variant->stock_quantity >= $this->quantity;
        }

        return $this->product->stock_quantity >= $this->quantity;
    }

    /**
     * Get available stock
     */
    public function getAvailableStock(): int
    {
        return $this->variant
            ? $this->variant->stock_quantity
            : $this->product->stock_quantity;
    }

    /**
     * Update quantity (with stock validation)
     */
    public function updateQuantity(int $quantity): bool
    {
        $availableStock = $this->getAvailableStock();

        if ($quantity > $availableStock) {
            return false;
        }

        $this->update(['quantity' => $quantity]);
        return true;
    }

    /**
     * Increment quantity
     */
    public function incrementQuantity(int $amount = 1): bool
    {
        return $this->updateQuantity($this->quantity + $amount);
    }

    /**
     * Get cart item display name
     */
    public function getDisplayName(): string
    {
        $name = $this->product->name;

        if ($this->variant) {
            $name .= ' - ' . $this->variant->getVariantName();
        }

        return $name;
    }
}
