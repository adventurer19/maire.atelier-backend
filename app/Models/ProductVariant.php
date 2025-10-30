<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// ============================================
// PRODUCT VARIANT MODEL
// ============================================

class ProductVariant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock_quantity',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $with = ['attributeOptions.attribute']; // auto eager load за атрибутите

    // ============================================
    // MEDIA LIBRARY
    // ============================================

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk('public')
            ->useFallbackUrl(asset('/images/placeholder-product.jpg'))
            ->useFallbackPath(public_path('/images/placeholder-product.jpg'))
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->height(400)
                    ->sharpen(10);

                $this->addMediaConversion('medium')
                    ->width(800)
                    ->height(800);

                $this->addMediaConversion('large')
                    ->width(1200)
                    ->height(1200);
            });
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Variant attribute options (e.g., Size: M, Color: Red)
     */
    public function attributeOptions(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeOption::class,
            'product_variant_attributes',
            'variant_id',
            'attribute_option_id'
        )->with('attribute');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'variant_id');
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class, 'variant_id');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Get display name (e.g., "Red / Large")
     */
    public function getVariantName(): string
    {
        return $this->attributeOptions
            ->map(fn($option) => $option->value)
            ->join(' / ');
    }

    /**
     * Get variant SKU or fallback to product SKU
     */
    public function getSku(): string
    {
        return $this->sku ?: $this->product->sku;
    }

    /**
     * Get final price (variant price or product price fallback)
     */
    public function getFinalPrice(): float
    {
        return (float) ($this->price ?? $this->product->price);
    }

    /**
     * Check if variant is in stock
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if variant is out of stock
     */
    public function isOutOfStock(): bool
    {
        return !$this->isInStock();
    }

    /**
     * Safely decrease stock
     */
    public function decreaseStock(int $quantity): void
    {
        if ($quantity > 0) {
            $this->update([
                'stock_quantity' => max(0, $this->stock_quantity - $quantity),
            ]);
        }
    }

    /**
     * Safely increase stock
     */
    public function increaseStock(int $quantity): void
    {
        if ($quantity > 0) {
            $this->increment('stock_quantity', $quantity);
        }
    }

    /**
     * Get attribute value by slug (e.g., "size" => "M")
     */
    public function getVariantAttributeValue(string $attributeSlug): ?string
    {
        $option = $this->attributeOptions
            ->first(fn($option) => $option->attribute->slug === $attributeSlug);

        return $option?->value;
    }

    /**
     * Get color hex if exists
     */
    public function getColorHex(): ?string
    {
        $colorOption = $this->attributeOptions
            ->first(fn($option) => $option->attribute->slug === 'color');

        return $colorOption?->hex_color;
    }

    /**
     * Get primary image URL (fallback to product image)
     */
    public function getPrimaryImageUrl(): string
    {
        return $this->getFirstMediaUrl('images', 'large')
            ?: $this->product->getPrimaryImageUrl();
    }

    /**
     * Get all image URLs (fallback to product)
     */
    public function getAllImageUrls(): array
    {
        $variantImages = $this->getMedia('images')->map(fn($m) => $m->getUrl())->toArray();

        return !empty($variantImages)
            ? $variantImages
            : $this->product->getAllImageUrls();
    }

    /**
     * Get thumbnail (fallback to product)
     */
    public function getThumbnailUrl(): string
    {
        return $this->getFirstMediaUrl('images', 'thumb')
            ?: $this->product->getThumbnailUrl();
    }

    /**
     * Get variant description (for front-end display)
     */
    public function getFormattedLabel(): string
    {
        $name = $this->getVariantName();
        $price = number_format($this->getFinalPrice(), 2) . ' BGN';
        return $name ? "{$name} - {$price}" : $price;
    }
}
