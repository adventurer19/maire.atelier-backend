<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'sku',
        'name',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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
     * Get variant name if exists
     */
    public function getVariantName(): ?string
    {
        return $this->variant?->getVariantName();
    }

    /**
     * Calculate subtotal
     */
    public function calculateSubtotal(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get display name (product name + variant if exists)
     */
    public function getDisplayName(): string
    {
        $name = $this->name;

        if ($variantName = $this->getVariantName()) {
            $name .= ' - ' . $variantName;
        }

        return $name;
    }
}
