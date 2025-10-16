<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_count',
        'valid_from',
        'valid_to',
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

    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED = 'fixed';

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_coupons')
            ->withPivot('discount_amount');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to only valid coupons (active, within date range, not exhausted)
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('valid_to')
                    ->orWhere('valid_to', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('usage_count < usage_limit');
            });
    }

    // ============================================
    // VALIDATION
    // ============================================

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) return false;

        if ($this->valid_from && now()->lt($this->valid_from)) return false;
        if ($this->valid_to && now()->gt($this->valid_to)) return false;

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;

        return true;
    }

    /**
     * Check if coupon can apply to amount
     */
    public function canApplyToAmount(float $amount): bool
    {
        return !$this->min_purchase_amount || $amount >= $this->min_purchase_amount;
    }

    /**
     * Calculate discount for given subtotal
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === self::TYPE_PERCENTAGE) {
            $discount = ($subtotal * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // Cap at max discount if set
        if ($this->max_discount_amount) {
            $discount = min($discount, $this->max_discount_amount);
        }

        // Don't exceed subtotal
        $discount = min($discount, $subtotal);

        return round($discount, 2);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Decrement usage count (for cancelled orders)
     */
    public function decrementUsage(): void
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    /**
     * Check if coupon is percentage type
     */
    public function isPercentage(): bool
    {
        return $this->type === self::TYPE_PERCENTAGE;
    }

    /**
     * Check if coupon is fixed type
     */
    public function isFixed(): bool
    {
        return $this->type === self::TYPE_FIXED;
    }

    /**
     * Get formatted discount value
     */
    public function getFormattedValue(): string
    {
        if ($this->isPercentage()) {
            return $this->value . '%';
        }
        return number_format($this->value, 2) . ' BGN';
    }

    /**
     * Check if coupon has usage limit
     */
    public function hasUsageLimit(): bool
    {
        return $this->usage_limit !== null;
    }

    /**
     * Get remaining uses
     */
    public function getRemainingUses(): ?int
    {
        if (!$this->hasUsageLimit()) {
            return null;
        }
        return max(0, $this->usage_limit - $this->usage_count);
    }

    /**
     * Check if coupon is exhausted
     */
    public function isExhausted(): bool
    {
        return $this->hasUsageLimit() && $this->usage_count >= $this->usage_limit;
    }
}
