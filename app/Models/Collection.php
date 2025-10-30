<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// ============================================
// COLLECTION MODEL (Manual / Automatic)
// ============================================

class Collection extends Model
{
    use HasFactory, HasTranslations, HasSlug;

    /**
     * Fillable attributes.
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'type',
        'image',
        'is_active',
        'is_featured',
        'position',
        'conditions', // JSON rules for auto collections
    ];

    /**
     * Translatable attributes.
     */
    public $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    /**
     * Cast definitions.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'position' => 'integer',
        'conditions' => 'array',
    ];

    public const TYPE_MANUAL = 'manual';
    public const TYPE_AUTO = 'auto';

    // -------------------------------------------------------------------------
    // ⚙️ SLUG CONFIGURATION
    // -------------------------------------------------------------------------

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn ($model) => $model->getTranslation('name', app()->getLocale()))
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(255)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // -------------------------------------------------------------------------
    // 🔗 RELATIONSHIPS
    // -------------------------------------------------------------------------

    /**
     * Products in this collection (ordered by pivot position)
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'collection_products')
            ->withPivot('position')
            ->orderBy('collection_products.position');
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeManual($query)
    {
        return $query->where('type', self::TYPE_MANUAL);
    }

    public function scopeAuto($query)
    {
        return $query->where('type', self::TYPE_AUTO);
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Check if collection is manual.
     */
    public function isManual(): bool
    {
        return $this->type === self::TYPE_MANUAL;
    }

    /**
     * Check if collection is automatic.
     */
    public function isAuto(): bool
    {
        return $this->type === self::TYPE_AUTO;
    }

    /**
     * Get total product count in the collection.
     */
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Add product to manual collection.
     */
    public function addProduct(Product $product, int $position = null): void
    {
        if (! $this->isManual()) {
            throw new \LogicException('Can only add products to manual collections.');
        }

        $position ??= ($this->products()->max('collection_products.position') ?? 0) + 1;

        $this->products()->attach($product->id, ['position' => $position]);
    }

    /**
     * Remove a product from the collection.
     */
    public function removeProduct(Product $product): void
    {
        $this->products()->detach($product->id);
    }

    /**
     * Reorder products in manual collection.
     */
    public function reorderProducts(array $productIdsInOrder): void
    {
        if (! $this->isManual()) {
            throw new \LogicException('Can only reorder manual collections.');
        }

        foreach ($productIdsInOrder as $position => $productId) {
            $this->products()->updateExistingPivot($productId, ['position' => $position + 1]);
        }
    }

    /**
     * Get image URL (local or S3 ready)
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/' . $this->image);
    }


    /**
     * Get short description for cards/lists.
     */
    public function getShortDescriptionAttribute(): string
    {
        return str($this->getTranslation('description', app()->getLocale()))->limit(120);
    }
}
