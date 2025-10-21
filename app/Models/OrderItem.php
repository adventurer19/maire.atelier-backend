<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'sku',
        'name',
        'quantity',
        'price',
        'total',
    ];

    /**
     * Type casting for numeric fields.
     */
    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    // -------------------------------------------------------------------------
    // 🔗 RELATIONS
    // -------------------------------------------------------------------------

    /**
     * The order this item belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The related product (may be null if deleted).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * The related product variant (if any).
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class)->withTrashed();
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Get the variant name (e.g. "Size M / Red").
     */
    public function getVariantName(): ?string
    {
        return $this->variant?->getVariantName();
    }

    /**
     * Calculate subtotal dynamically (if not stored).
     */
    public function getSubtotalAttribute(): float
    {
        return $this->total ?? ($this->price * $this->quantity);
    }

    /**
     * Get the display name combining product and variant.
     */
    public function getDisplayName(): string
    {
        $name = $this->name ?? $this->product?->name ?? 'Unnamed Product';

        if ($variantName = $this->getVariantName()) {
            $name .= ' - ' . $variantName;
        }

        return $name;
    }
}
