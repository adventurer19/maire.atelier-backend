<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ============================================
// ORDER MODEL
// ============================================

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'status',
        'payment_status',
        'payment_method',
        'subtotal',
        'shipping_total',
        'tax_total',
        'discount_total',
        'total',
        'currency',
        'notes',
        'customer_ip',
        'user_agent',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // --------------------------------------------
    // STATUS CONSTANTS
    // --------------------------------------------

    public const STATUS_PENDING     = 'pending';
    public const STATUS_PROCESSING  = 'processing';
    public const STATUS_SHIPPED     = 'shipped';
    public const STATUS_DELIVERED   = 'delivered';
    public const STATUS_CANCELLED   = 'cancelled';
    public const STATUS_REFUNDED    = 'refunded';

    public const PAYMENT_PENDING    = 'pending';
    public const PAYMENT_PAID       = 'paid';
    public const PAYMENT_FAILED     = 'failed';
    public const PAYMENT_REFUNDED   = 'refunded';

    // --------------------------------------------
    // RELATIONSHIPS
    // --------------------------------------------

    /**
     * The customer user (if registered)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order items (products)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Shipping address (OrderAddress model)
     */
    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'shipping');
    }

    /**
     * Billing address (OrderAddress model)
     */
    public function billingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'billing');
    }

    /**
     * Applied coupons
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'order_coupons')
            ->withPivot('discount_amount')
            ->withTimestamps();
    }

    // --------------------------------------------
    // SCOPES
    // --------------------------------------------

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }

    // --------------------------------------------
    // HELPERS
    // --------------------------------------------

    /**
     * Generate unique order number.
     */
    public static function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    /**
     * Check if the order is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    /**
     * Check if order can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    /**
     * Cancel order and restore stock.
     */
    public function cancel(): void
    {
        if (! $this->canBeCancelled()) {
            throw new \RuntimeException('Order cannot be cancelled.');
        }

        $this->update(['status' => self::STATUS_CANCELLED]);

        foreach ($this->items as $item) {
            if ($item->variant_id && $item->variant) {
                $item->variant->increaseStock($item->quantity);
            } elseif ($item->product) {
                $item->product->increaseStock($item->quantity);
            }
        }
    }

    /**
     * Total quantity of items in the order.
     */
    public function getTotalItemsCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Calculate total discount applied to this order.
     */
    public function getTotalDiscountAttribute(): float
    {
        return $this->coupons->sum(fn ($c) => $c->pivot->discount_amount);
    }

    /**
     * Determine if order belongs to guest user.
     */
    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    /**
     * Get full customer name.
     */
    public function getCustomerNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }

        return $this->guest_name ?: __('Guest');
    }

    /**
     * Mark as paid.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'payment_status' => self::PAYMENT_PAID,
            'status' => self::STATUS_PROCESSING,
        ]);
    }

    /**
     * Mark as shipped.
     */
    public function markAsShipped(): void
    {
        $this->update(['status' => self::STATUS_SHIPPED]);
    }

    /**
     * Mark as delivered.
     */
    public function markAsDelivered(): void
    {
        $this->update(['status' => self::STATUS_DELIVERED]);
    }

    /**
     * Check if order is completed (delivered or refunded).
     */
    public function isCompleted(): bool
    {
        return in_array($this->status, [self::STATUS_DELIVERED, self::STATUS_REFUNDED]);
    }

    /**
     * Get formatted total with currency.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2) . ' ' . strtoupper($this->currency ?? 'BGN');
    }
}
