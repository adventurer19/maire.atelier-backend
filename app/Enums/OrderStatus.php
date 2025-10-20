<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'В изчакване',
            self::PROCESSING => 'Обработва се',
            self::SHIPPED => 'Изпратена',
            self::DELIVERED => 'Доставена',
            self::CANCELLED => 'Анулирана',
            self::REFUNDED => 'Възстановена',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::SHIPPED => 'primary',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
            self::REFUNDED => 'gray',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => 'heroicon-o-clock',
            self::PROCESSING => 'heroicon-o-cog-6-tooth',
            self::SHIPPED => 'heroicon-o-truck',
            self::DELIVERED => 'heroicon-o-check-circle',
            self::CANCELLED => 'heroicon-o-x-circle',
            self::REFUNDED => 'heroicon-o-arrow-uturn-left',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
