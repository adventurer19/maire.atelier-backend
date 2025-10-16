<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ============================================
// PRODUCT MEDIA MODEL (Link between products and media)
// ============================================

class ProductMedia extends Model
{
    protected $fillable = [
        'product_id',
        'media_id',
        'variant_id',
        'position',
        'is_primary',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_primary' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope to only primary images
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope ordered by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    /**
     * Scope to product-level media (not variant-specific)
     */
    public function scopeProductLevel($query)
    {
        return $query->whereNull('variant_id');
    }

    /**
     * Scope to variant-specific media
     */
    public function scopeForVariant($query, $variantId)
    {
        return $query->where('variant_id', $variantId);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Set as primary image (removes primary from others)
     */
    public function setAsPrimary(): void
    {
        // Remove primary from other images of same product
        self::where('product_id', $this->product_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        $this->update(['is_primary' => true]);
    }

    /**
     * Check if this is variant-specific media
     */
    public function isVariantSpecific(): bool
    {
        return $this->variant_id !== null;
    }

    /**
     * Get media URL (shortcut)
     */
    public function getUrl(): string
    {
        return $this->media->url;
    }
}
