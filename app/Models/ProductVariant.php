<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductVariant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    protected $with = ['attributeOptions', 'media'];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('/images/placeholder-product.jpg')
            ->useFallbackPath(public_path('/images/placeholder-product.jpg'));
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get attribute options (Size: M, Color: Red)
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
     * Get variant display name (e.g., "Red / Large")
     */
    public function getVariantName(): string
    {
        return $this->attributeOptions
            ->map(fn($option) => $option->value)
            ->join(' / ');
    }

    /**
     * Get final price (variant price or fall back to product price)
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
        return $this->stock_quantity <= 0;
    }

    /**
     * Decrease stock
     */
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }

    /**
     * Increase stock
     */
    public function increaseStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    /**
     * Get attribute value by slug (e.g., "size" => "M")
     */
    public function getAttributeValue(string $attributeSlug): ?string
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
     * Get primary image URL
     */
    public function getPrimaryImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('images') ?: $this->product->getPrimaryImageUrl();
    }

    /**
     * Get all image URLs (fall back to product images if no variant images)
     */
    public function getAllImageUrls(): array
    {
        $variantImages = $this->getMedia('images')->map(fn($media) => $media->getUrl())->toArray();

        if (empty($variantImages)) {
            return $this->product->getAllImageUrls();
        }

        return $variantImages;
    }
}
