<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

// ============================================
// ATTRIBUTE OPTION MODEL (e.g. S, M, L / Red, Blue)
// ============================================

class AttributeOption extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'attribute_id',
        'slug',
        'value',
        'hex_color',
        'position',
        'is_active',
    ];

    /**
     * Translatable fields.
     */
    public $translatable = ['value'];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // 🔗 RELATIONS
    // -------------------------------------------------------------------------

    /**
     * Parent attribute (e.g. "Color", "Size").
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Product variants using this option.
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

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    /**
     * Order options by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    /**
     * Filter only active options.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // -------------------------------------------------------------------------
    // 💡 HELPERS
    // -------------------------------------------------------------------------

    /**
     * Whether the option has a color (used for swatch attributes).
     */
    public function hasColor(): bool
    {
        return !empty($this->hex_color);
    }

    /**
     * Get a human-readable display name, e.g. "Color: Red"
     */
    public function getFullDisplayNameAttribute(): string
    {
        $attributeName = $this->attribute?->name ?? 'Attribute';
        $value = is_array($this->value) ? ($this->value['en'] ?? reset($this->value)) : $this->value;

        return "{$attributeName}: {$value}";
    }

    /**
     * Get display label for UI (value or color swatch).
     */
    public function getDisplayLabelAttribute(): string
    {
        return $this->hasColor()
            ? strtoupper($this->value)
            : ucfirst($this->value);
    }

    /**
     * Convert option into a simple array (for API resource fallback)
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'value' => $this->value,
            'hex_color' => $this->hex_color,
            'is_color' => $this->hasColor(),
        ];
    }
}
