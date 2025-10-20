<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'sku',
        'slug',
        'name',
        'description',
        'short_description',
        'material',
        'care_instructions',
        'meta_title',
        'meta_description',
        'price',
        'compare_at_price',
        'cost_price',
        'is_active',
        'is_featured',
        'stock_quantity',
        'low_stock_threshold',
        'stock_status',
        'is_taxable',
        'requires_shipping',
        'weight',
        'width',
        'height',
        'depth',
    ];

    public $translatable = [
        'name',
        'description',
        'short_description',
        'material',
        'care_instructions',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_taxable' => 'boolean',
        'requires_shipping' => 'boolean',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'weight' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'depth' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(255);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Register media collections for Spatie Media Library
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->useFallbackUrl('/images/placeholder-product.jpg')
            ->useFallbackPath(public_path('/images/placeholder-product.jpg'));
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_products')
            ->withPivot('position')
            ->orderBy('collection_products.position');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    // ============================================
    // IMAGE HELPER METHODS
    // ============================================

    /**
     * Get primary/first image URL
     */
    public function getPrimaryImageUrl(): ?string
    {
        $media = $this->getFirstMedia('images');

        return $media ? $media->getUrl() : asset('/images/placeholder-product.jpg');
    }

    /**
     * Get all product image URLs
     */
    public function getAllImageUrls(): array
    {
        return $this->getMedia('images')
            ->map(fn($media) => $media->getUrl())
            ->toArray();
    }

    /**
     * Get thumbnail URL (medium size)
     */
    public function getThumbnailUrl(string $conversion = 'thumb'): ?string
    {
        $media = $this->getFirstMedia('images');

        return $media ? $media->getUrl($conversion) : asset('/images/placeholder-product.jpg');
    }

    /**
     * Check if product has images
     */
    public function hasImages(): bool
    {
        return $this->hasMedia('images');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0)
            ->orWhere('stock_status', 'in_stock');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0 || $this->stock_status === 'in_stock';
    }

    /**
     * Check if stock is low
     */
    public function isLowStock(): bool
    {
        if (!$this->low_stock_threshold) {
            return false;
        }

        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * Get final price (considering discount)
     */
    public function getFinalPrice(): float
    {
        return (float) $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentage(): ?int
    {
        if (!$this->compare_at_price || $this->compare_at_price <= $this->price) {
            return null;
        }

        return (int) round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
    }

    /**
     * Check if product has discount
     */
    public function hasDiscount(): bool
    {
        return $this->compare_at_price && $this->compare_at_price > $this->price;
    }
}
