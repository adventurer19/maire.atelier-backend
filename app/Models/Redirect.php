<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ============================================
// REDIRECT MODEL
// ============================================

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_url',
        'new_url',
        'status_code',
        'is_active',
    ];

    protected $casts = [
        'status_code' => 'integer',
        'is_active' => 'boolean',
    ];

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope only active redirects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Find redirect by old URL (normalized)
     */
    public function scopeByOldUrl($query, string $url)
    {
        return $query->where('old_url', self::normalizeUrl($url));
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Normalize URLs for comparison
     * Removes domain and trailing slashes
     */
    public static function normalizeUrl(string $url): string
    {
        $parsed = parse_url($url);

        // Extract only path part (ignore domain)
        $path = $parsed['path'] ?? '/';

        // Remove trailing slash except for root
        return $path === '/' ? '/' : rtrim($path, '/');
    }

    /**
     * Create or update redirect
     */
    public static function createOrUpdateRedirect(string $old, string $new, int $status = 301): self
    {
        return self::updateOrCreate(
            ['old_url' => self::normalizeUrl($old)],
            [
                'new_url'     => self::normalizeUrl($new),
                'status_code' => $status,
                'is_active'   => true,
            ]
        );
    }

    /**
     * Get full redirect response (for middleware)
     */
    public function getRedirectResponse()
    {
        return redirect($this->new_url, $this->status_code);
    }
}
