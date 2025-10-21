<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    const TYPE_STRING  = 'string';
    const TYPE_NUMBER  = 'number';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_JSON    = 'json';

    /**
     * Cache duration for settings (in seconds)
     */
    const CACHE_TTL = 3600; // 1 hour

    // ============================================
    // STATIC HELPERS
    // ============================================

    /**
     * Get setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "setting:{$key}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set or update setting value
     */
    public static function set(string $key, $value, string $type = self::TYPE_STRING): void
    {
        $storedValue = is_array($value) ? json_encode($value) : $value;

        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $storedValue,
                'type' => $type,
            ]
        );

        Cache::forget("setting:{$key}");
    }

    /**
     * Get all settings as key-value array
     */
    public static function allAsArray(): array
    {
        return Cache::remember('settings:all', self::CACHE_TTL, function () {
            return self::all()
                ->mapWithKeys(fn($s) => [$s->key => self::castValue($s->value, $s->type)])
                ->toArray();
        });
    }

    /**
     * Clear all cached settings
     */
    public static function clearCache(): void
    {
        Cache::forget('settings:all');
        foreach (self::pluck('key') as $key) {
            Cache::forget("setting:{$key}");
        }
    }

    /**
     * Cast raw database value to proper PHP type
     */
    private static function castValue($value, string $type)
    {
        return match ($type) {
            self::TYPE_NUMBER  => (float) $value,
            self::TYPE_BOOLEAN => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            self::TYPE_JSON    => json_decode($value, true),
            default             => $value,
        };
    }
}
