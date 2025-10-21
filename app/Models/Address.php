<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ============================================
// ADDRESS MODEL
// ============================================

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        'is_default',
        'email', // ✅ Useful for guest checkouts
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public const TYPE_SHIPPING = 'shipping';
    public const TYPE_BILLING = 'billing';

    // -------------------------------------------------------------------------
    // 🔗 RELATIONS
    // -------------------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // -------------------------------------------------------------------------
    // 🔍 SCOPES
    // -------------------------------------------------------------------------

    public function scopeShipping($query)
    {
        return $query->where('type', self::TYPE_SHIPPING);
    }

    public function scopeBilling($query)
    {
        return $query->where('type', self::TYPE_BILLING);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // -------------------------------------------------------------------------
    // 🧠 ACCESSORS
    // -------------------------------------------------------------------------

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

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

    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }

    // -------------------------------------------------------------------------
    // ⚙️ HELPERS
    // -------------------------------------------------------------------------

    /**
     * Mark this address as the default for its type.
     */
    public function setAsDefault(): void
    {
        static::where('user_id', $this->user_id)
            ->where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->update(['is_default' => true]);
    }

    /**
     * Convert address to a simple string for order summary / emails.
     */
    public function toSummaryString(): string
    {
        return sprintf(
            "%s\n%s\n%s %s\n%s",
            $this->full_name,
            $this->address_line1,
            $this->postal_code,
            $this->city,
            $this->country
        );
    }
}
