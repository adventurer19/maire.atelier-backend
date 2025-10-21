<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ============================================
// COUPON MODEL
// ============================================

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'min_purchase_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_count',
        'valid_from',
        'valid_to',
        'applies_to', // 'all', 'category', 'product'
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_count' => 'integer',
        'usage_limit' => 'integer',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'is_active' => 'boolean',
    ];

    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_FIXED = 'fixed';

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Orders using this coupon
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_coupons')
            ->withPivot('discount_amount')
            ->withTimestamps();
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Active coupons only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Coupons that are valid for current date and usage count
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_to')
                    ->orWhere('valid_to', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('usage_count < usage_limit');
            });
    }

    // ============================================
    // VALIDATION HELPERS
    // ============================================

    /**
     * Check if coupon is currently valid
     */
    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->valid_from && now()->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_to && now()->gt($this->valid_to)) {
            return false;
        }

        if ($this->hasUsageLimit() && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon can be applied to a subtotal amount
     */
    public function canApplyToAmount(float $subtotal): bool
    {
        return ! $this->min_purchase_amount || $subtotal >= $this->min_purchase_amount;
    }

    /**
     * Calculate discount based on coupon type
     */
    public function calculateDiscount(float $subtotal): float
    {
        $discount = $this->isPercentage()
            ? ($subtotal * ($this->value / 100))
            : $this->value;

        if ($this->max_discount_amount) {
            $discount = min($discount, $this->max_discount_amount);
        }

        // Ensure discount never exceeds subtotal
        return round(min($discount, $subtotal), 2);
    }

    // ============================================
    // COUNTERS
    // ============================================

    /**
     * Increment coupon usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Decrement usage (e.g. cancelled order)
     */
    public function decrementUsage(): void
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    // ============================================
    // TYPE CHECKS
    // ============================================

    public function isPercentage(): bool
    {
        return $this->type === self::TYPE_PERCENTAGE;
    }

    public function isFixed(): bool
    {
        return $this->type === self::TYPE_FIXED;
    }

    // ============================================
    // LIMIT HELPERS
    // ============================================

    public function hasUsageLimit(): bool
    {
        return $this->usage_limit !== null;
    }

    public function getRemainingUses(): ?int
    {
        if (! $this->hasUsageLimit()) {
            return null;
        }

        return max(0, $this->usage_limit - $this->usage_count);
    }

    public function isExhausted(): bool
    {
        return $this->hasUsageLimit() && $this->usage_count >= $this->usage_limit;
    }

    // ============================================
    // ACCESSORS / HELPERS
    // ============================================

    /**
     * Get formatted coupon value (for display)
     */
    public function getFormattedValueAttribute(): string
    {
        return $this->isPercentage()
            ? "{$this->value}%"
            : number_format($this->value, 2) . ' BGN';
    }

    /**
     * Display full name with code + value
     */
    public function getDisplayNameAttribute(): string
    {
        return strtoupper($this->code) . ' (' . $this->formatted_value . ')';
    }

    /**
     * Check if coupon applies to all products
     */
    public function appliesToAll(): bool
    {
        return $this->applies_to === 'all' || empty($this->applies_to);
    }
}
