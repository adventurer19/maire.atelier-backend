<?php

namespace App\Models;

use App\Enums\UserRole;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ============================================
// USER MODEL
// ============================================

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Attributes that should be hidden.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
        ];
    }

    // ============================================
    // FILAMENT ACCESS CONTROL
    // ============================================

    /**
     * Determine if user can access Filament admin panel
     * ✅ Only admins can log in
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function shippingAddresses(): HasMany
    {
        return $this->addresses()->where('type', 'shipping');
    }

    public function billingAddresses(): HasMany
    {
        return $this->addresses()->where('type', 'billing');
    }

    public function defaultShippingAddress()
    {
        return $this->shippingAddresses()->where('is_default', true)->first();
    }

    public function defaultBillingAddress()
    {
        return $this->billingAddresses()->where('is_default', true)->first();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ============================================
    // ROLE HELPERS
    // ============================================

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    /**
     * Check if user is editor / manager (optional)
     */
    public function isEditor(): bool
    {
        return $this->role === UserRole::Editor;
    }

    /**
     * Get formatted display name
     */
    public function getDisplayName(): string
    {
        return $this->name ?: __('Guest');
    }

    /**
     * Check if user is a guest (not authenticated)
     */
    public function isGuest(): bool
    {
        return !$this->exists;
    }
}
