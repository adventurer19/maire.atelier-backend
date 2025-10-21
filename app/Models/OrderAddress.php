<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ============================================
// ORDER ADDRESS MODEL (Shipping / Billing)
// ============================================

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'type',
        'first_name',
        'last_name',
        'company',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'email',
    ];

    protected $casts = [
        'order_id' => 'integer',
    ];

    // --------------------------------------------
    // CONSTANTS
    // --------------------------------------------

    public const TYPE_SHIPPING = 'shipping';
    public const TYPE_BILLING  = 'billing';

    // --------------------------------------------
    // RELATIONSHIPS
    // --------------------------------------------

    /**
     * The order this address belongs to
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // --------------------------------------------
    // SCOPES
    // --------------------------------------------

    public function scopeShipping($query)
    {
        return $query->where('type', self::TYPE_SHIPPING);
    }

    public function scopeBilling($query)
    {
        return $query->where('type', self::TYPE_BILLING);
    }

    // --------------------------------------------
    // ACCESSORS
    // --------------------------------------------

    /**
     * Full customer name
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Full formatted address
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Compact single-line label for dropdowns or invoices
     */
    public function getFormattedLabelAttribute(): string
    {
        return $this->full_name . ' — ' . $this->getFullAddressAttribute();
    }

    // --------------------------------------------
    // HELPERS
    // --------------------------------------------

    public function isShipping(): bool
    {
        return $this->type === self::TYPE_SHIPPING;
    }

    public function isBilling(): bool
    {
        return $this->type === self::TYPE_BILLING;
    }
}
