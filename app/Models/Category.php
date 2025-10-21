<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// ============================================
// CATEGORY MODEL
// ============================================

class Category extends Model
{
    use HasFactory, HasTranslations, HasSlug;

    protected $fillable = [
        'parent_id',
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'image',
        'position',
        'is_active',
        'is_featured',
        'show_in_menu',
    ];

    public $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'show_in_menu' => 'boolean',
        'position' => 'integer',
    ];

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
     * Parent category (self-reference)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->active()
            ->ordered();
    }

    /**
     * All products assigned to this category
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeMenuVisible($query)
    {
        return $query->where('show_in_menu', true);
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Whether the category has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Get a full breadcrumb-like path (Parent > Child > Grandchild)
     */
    public function getFullPath(): string
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    /**
     * Get all ancestor categories.
     */
    public function getAncestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Get category image URL (local or S3)
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? (str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image))
            : null;
    }

    /**
     * Get translated meta title fallback to name.
     */
    public function getMetaTitleAttribute(): string
    {
        return $this->getTranslation('meta_title', app()->getLocale()) ?: $this->getTranslation('name', app()->getLocale());
    }
}
