<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ============================================
// ATTRIBUTE OPTION MODEL (S, M, L / Red, Blue)
// ============================================

class AttributeOption extends Model
{
    use HasTranslations;

    protected $fillable = [
        'attribute_id',
        'slug',
        'value',
        'hex_color',
        'position',
    ];

    public $translatable = ['value'];

    protected $casts = [
        'position' => 'integer',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get parent attribute
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get all variants using this option
     */
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_attributes',
            'attribute_option_id',
            'variant_id'
        );
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Check if option has color
     */
    public function hasColor(): bool
    {
        return !empty($this->hex_color);
    }

    /**
     * Get display value with attribute name
     * Example: "Size: Large", "Color: Red"
     */
    public function getFullDisplayName(): string
    {
        return $this->attribute->name . ': ' . $this->value;
    }
}
