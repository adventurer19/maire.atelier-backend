<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ============================================
// REDIRECT MODEL
// ============================================

class Redirect extends Model
{
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByOldUrl($query, string $url)
    {
        return $query->where('old_url', $url);
    }

}

