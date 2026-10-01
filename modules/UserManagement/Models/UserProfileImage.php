<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserProfileImage extends Model
{
    use HasFactory;

    protected $table = 'user_profile_image';

    protected $fillable = [
        'user_id',
        'file_path',
        'filename',
        'file_format',
        'file_size',
        'mime_type',
        'width',
        'height',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByFormat($query, $format)
    {
        return $query->where('file_format', $format);
    }

    public function scopeOrderedByDate($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helper methods
    public function getFormattedSize()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFullUrl()
    {
        return Storage::url($this->file_path);
    }

    public function getPublicPath()
    {
        return 'storage/' . str_replace('public/', '', $this->file_path);
    }

    public function getDimensionsString()
    {
        if ($this->width && $this->height) {
            return $this->width . 'x' . $this->height;
        }
        return null;
    }

    public function isImage()
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    public function isJpeg()
    {
        return in_array($this->file_format, ['jpg', 'jpeg']);
    }

    public function isPng()
    {
        return $this->file_format === 'png';
    }

    public function isWebp()
    {
        return $this->file_format === 'webp';
    }

    // Static methods
    public static function getActiveForUser($userId)
    {
        return static::active()->forUser($userId)->orderedByDate()->first();
    }

    public static function deactivateUserImages($userId)
    {
        return static::forUser($userId)->active()->update(['is_active' => false]);
    }

    public static function getTotalSizeForUser($userId)
    {
        return static::forUser($userId)->sum('file_size');
    }

    // Model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($profileImage) {
            // Delete physical file when model is deleted
            if (Storage::exists($profileImage->file_path)) {
                Storage::delete($profileImage->file_path);
            }
        });
    }
}