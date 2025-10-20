<?php

namespace App\Enums;

enum UserRole: string
{
    case CUSTOMER = 'customer';
    case ADMIN = 'admin';

    /**
     * Get translated label
     */
    public function label(): string
    {
        return __('enums.user_role.' . $this->value);
    }

    /**
     * Get color for Filament badges
     */
    public function color(): string
    {
        return match($this) {
            self::CUSTOMER => 'gray',
            self::ADMIN => 'success',
        };
    }

    /**
     * Get icon for Filament
     */
    public function icon(): string
    {
        return match($this) {
            self::CUSTOMER => 'heroicon-o-user',
            self::ADMIN => 'heroicon-o-shield-check',
        };
    }

    /**
     * Check if user can access admin panel
     */
    public function canAccessAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this === self::CUSTOMER;
    }

    /**
     * Get all values as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get options for select fields (value => label)
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
