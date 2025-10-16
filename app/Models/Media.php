<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ============================================
// MEDIA MODEL (Centralized file storage)
// ============================================

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'size',
        'alt_text',
        'width',
        'height',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get all product media relations
     */
    public function productMedia(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Get full URL for the media file
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get thumbnail URL (if exists)
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        $thumbnailPath = str_replace('/', '/thumbs/', $this->path);

        if (file_exists(storage_path('app/public/' . $thumbnailPath))) {
            return asset('storage/' . $thumbnailPath);
        }

        return $this->url;
    }

    // ============================================
    // HELPERS
    // ============================================

    /**
     * Check if media is an image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if media is a video
     */
    public function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Get human readable file size
     */
    public function getFormattedSize(): string
    {
        $bytes = $this->size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get aspect ratio
     */
    public function getAspectRatio(): ?float
    {
        if (!$this->width || !$this->height) {
            return null;
        }

        return round($this->width / $this->height, 2);
    }
}
