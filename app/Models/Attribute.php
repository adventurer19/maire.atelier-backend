<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

// ============================================
// ATTRIBUTE MODEL (e.g. Size, Color, Material)
// ============================================

class Attribute extends Model
{
    use HasFactory, HasTranslations;

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'slug',
        'name',
        'type',
        'position',
        'is_filterable',
        'is_visible',
    ];

    /**
     * Translatable fields.
     */
    public $translatable = ['name'];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'position' => 'integer',
        'is_filterable' => 'boolean',
        'is_visible' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // 📌 TYPES
    // -------------------------------------------------------------------------

    public const TYPE_SELECT = 'select'; // dropdown (e.g. Size)
    public const TYPE_SWATCH = 'swatch'; // color picker (e.g. Color)

    // -------------------------------------------------------------------------
    // 🔗 RELATIONS
    // -------------------------------------------------------------------------

    /**
     * All options for this attribute.
     */
    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class)->orderBy('position');
    }

    /**
     * Products that use this attribute (via product_attributes pivot).
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attributes');
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    /**
     * Order attributes by their position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    /**
     * Filter attributes visible on product page.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Filter attributes usable for filtering products (in sidebar).
     */
    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Whether this attribute is a color swatch type.
     */
    public function isSwatch(): bool
    {
        return $this->type === self::TYPE_SWATCH;
    }

    /**
     * Whether this attribute is a select/dropdown type.
     */
    public function isSelect(): bool
    {
        return $this->type === self::TYPE_SELECT;
    }

    /**
     * Retrieve an option by its slug.
     */
    public function getOptionBySlug(string $slug): ?AttributeOption
    {
        return $this->options()->where('slug', $slug)->first();
    }

    /**
     * Return a human-readable label for the attribute type.
     */
    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }
}
