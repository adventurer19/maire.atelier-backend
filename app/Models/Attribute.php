<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

// ============================================
// ATTRIBUTE MODEL (Size, Color, Material)
// ============================================

class Attribute extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug',
        'name',
        'type',
        'position',
    ];

    public $translatable = ['name'];

    protected $casts = [
        'position' => 'integer',
    ];

    // Types: select (dropdown), swatch (color picker)
    const TYPE_SELECT = 'select';
    const TYPE_SWATCH = 'swatch';

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get all options for this attribute
     */
    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class)->orderBy('position');
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
     * Check if attribute is swatch type (for colors)
     */
    public function isSwatch(): bool
    {
        return $this->type === self::TYPE_SWATCH;
    }

    /**
     * Check if attribute is select type
     */
    public function isSelect(): bool
    {
        return $this->type === self::TYPE_SELECT;
    }

    /**
     * Get option by slug
     */
    public function getOptionBySlug(string $slug): ?AttributeOption
    {
        return $this->options()->where('slug', $slug)->first();
    }
}

