<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case Editor = 'editor';

    /**
     * Get translated label
     */
    public function label(): string
    {
        return match($this) {
            self::Admin    => __('Admin'),
            self::Customer => __('Customer'),
            self::Editor   => __('Editor'),
        };
    }

    /**
     * Get color for Filament badges
     */
    public function color(): string
    {
        return match($this) {
            self::Admin    => 'success',
            self::Editor   => 'warning',
            self::Customer => 'gray',
        };
    }

    /**
     * Get icon for Filament
     */
    public function icon(): string
    {
        return match($this) {
            self::Admin    => 'heroicon-o-shield-check',
            self::Editor   => 'heroicon-o-pencil-square',
            self::Customer => 'heroicon-o-user',
        };
    }

    /**
     * Permission helpers
     */
    public function canAccessAdmin(): bool
    {
        return in_array($this, [self::Admin, self::Editor]);
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isCustomer(): bool
    {
        return $this === self::Customer;
    }

    public function isEditor(): bool
    {
        return $this === self::Editor;
    }

    /**
     * Utility methods
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
