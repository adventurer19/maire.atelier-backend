<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Collection extends Model
{
    use HasTranslations, HasSlug;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'type',
        'is_active',
        'position',
    ];

    public $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    const TYPE_MANUAL = 'manual';
    const TYPE_AUTO = 'auto';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Products in this collection (with manual position sorting)
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'collection_products')
            ->withPivot('position')
            ->orderBy('collection_products.position');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public function scopeManual($query)
    {
        return $query->where('type', self::TYPE_MANUAL);
    }

    public function scopeAuto($query)
    {
        return $query->where('type', self::TYPE_AUTO);
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Check if collection is manual
     */
    public function isManual(): bool
    {
        return $this->type === self::TYPE_MANUAL;
    }

    /**
     * Check if collection is auto
     */
    public function isAuto(): bool
    {
        return $this->type === self::TYPE_AUTO;
    }

    /**
     * Get products count
     */
    public function getProductsCount(): int
    {
        return $this->products()->count();
    }

    /**
     * Add product to collection (manual only)
     */
    public function addProduct(Product $product, int $position = null): void
    {
        if (!$this->isManual()) {
            throw new \Exception('Can only add products to manual collections');
        }

        if ($position === null) {
            $position = $this->products()->max('collection_products.position') + 1;
        }

        $this->products()->attach($product->id, ['position' => $position]);
    }

    /**
     * Remove product from collection
     */
    public function removeProduct(Product $product): void
    {
        $this->products()->detach($product->id);
    }

    /**
     * Reorder products in collection
     */
    public function reorderProducts(array $productIdsInOrder): void
    {
        if (!$this->isManual()) {
            throw new \Exception('Can only reorder manual collections');
        }

        foreach ($productIdsInOrder as $position => $productId) {
            $this->products()->updateExistingPivot($productId, [
                'position' => $position
            ]);
        }
    }
}
