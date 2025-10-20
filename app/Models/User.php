<?php

namespace App\Models;

use App\Enums\UserRole;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class
        ];
    }

    /**
     * Determine if user can access Filament admin panel
     * ✅ Само admins могат да влязат в Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
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
}
