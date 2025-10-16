<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ============================================
// SETTING MODEL (Key-Value Store)
// ============================================

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    const TYPE_STRING = 'string';
    const TYPE_NUMBER = 'number';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_JSON = 'json';

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Get setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = self::TYPE_STRING): void
    {
        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
            ]
        );
    }

    /**
     * Cast value to proper type
     */
    private static function castValue($value, string $type)
    {
        return match($type) {
            self::TYPE_NUMBER => (float) $value,
            self::TYPE_BOOLEAN => (bool) $value,
            self::TYPE_JSON => json_decode($value, true),
            default => $value,
        };
    }
}
