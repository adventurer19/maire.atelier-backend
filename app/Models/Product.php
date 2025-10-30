<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// ============================================
// PRODUCT MODEL
// ============================================

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, HasSlug, InteractsWithMedia, SoftDeletes;

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
        'price'               => 'decimal:2',
        'compare_at_price'    => 'decimal:2',
        'cost_price'          => 'decimal:2',
        'is_active'           => 'boolean',
        'is_featured'         => 'boolean',
        'is_taxable'          => 'boolean',
        'requires_shipping'   => 'boolean',
        'stock_quantity'      => 'integer',
        'low_stock_threshold' => 'integer',
        'weight'              => 'decimal:2',
        'width'               => 'decimal:2',
        'height'              => 'decimal:2',
        'depth'               => 'decimal:2',
    ];

    // --------------------------------------------
    // SLUG OPTIONS
    // --------------------------------------------

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn($product) => $product->getTranslation('name', app()->getLocale()))
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(255);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // --------------------------------------------
    // MEDIA LIBRARY
    // --------------------------------------------

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->useDisk('public')
            ->useFallbackUrl(asset('images/placeholder-product.jpg'))
            ->useFallbackPath(public_path('images/placeholder-product.jpg'))
            ->registerMediaConversions(function (Media $media = null) {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->height(400)
                    ->sharpen(10)
                    ->nonQueued();

                $this->addMediaConversion('medium')
                    ->width(800)
                    ->height(800)
                    ->nonQueued();

                $this->addMediaConversion('large')
                    ->width(1200)
                    ->height(1200)
                    ->nonQueued();
            });
    }

    // --------------------------------------------
    // RELATIONSHIPS
    // --------------------------------------------

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

    // --------------------------------------------
    // IMAGE HELPERS (SAFE)
    // --------------------------------------------

    public function getPrimaryImageUrl(): string
    {
        try {
            return $this->getFirstMediaUrl('images', 'large') ?: asset('images/placeholder-product.jpg');
        } catch (\Throwable $e) {
            return asset('images/placeholder-product.jpg');
        }
    }

    public function getThumbnailUrl(): string
    {
        try {
            return $this->getFirstMediaUrl('images', 'thumb') ?: asset('images/placeholder-product.jpg');
        } catch (\Throwable $e) {
            return asset('images/placeholder-product.jpg');
        }
    }

    public function getAllImageUrls(): array
    {
        try {
            return $this->getMedia('images')
                ->map(fn($media) => $media->getUrl())
                ->toArray();
        } catch (\Throwable $e) {
            return [asset('images/placeholder-product.jpg')];
        }
    }

    public function hasImages(): bool
    {
        try {
            return $this->hasMedia('images');
        } catch (\Throwable $e) {
            return false;
        }
    }

    // --------------------------------------------
    // SCOPES
    // --------------------------------------------

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
        return $query->where(function ($q) {
            $q->where('stock_quantity', '>', 0)
                ->orWhere('stock_status', 'in_stock');
        });
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
    }

    // --------------------------------------------
    // LOGIC & HELPERS
    // --------------------------------------------

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0 || $this->stock_status === 'in_stock';
    }

    public function isLowStock(): bool
    {
        return $this->low_stock_threshold
            ? $this->stock_quantity <= $this->low_stock_threshold
            : false;
    }

    public function hasDiscount(): bool
    {
        return $this->compare_at_price && $this->compare_at_price > $this->price;
    }

    public function getFinalPrice(): float
    {
        return (float) $this->price;
    }

    public function getDiscountPercentage(): ?int
    {
        if (!$this->hasDiscount()) {
            return null;
        }

        return (int) round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
    }

    public function increaseStock(int $qty): void
    {
        $this->increment('stock_quantity', $qty);
    }

    public function decreaseStock(int $qty): void
    {
        if ($this->stock_quantity >= $qty) {
            $this->decrement('stock_quantity', $qty);
        } else {
            $this->update(['stock_quantity' => 0]);
        }
    }
}
