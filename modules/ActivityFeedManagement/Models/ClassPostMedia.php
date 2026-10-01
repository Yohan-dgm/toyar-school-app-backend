<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class ClassPostMedia extends Model
{
    use HasFactory;

    protected $table = 'class_post_media';

    protected $fillable = [
        'post_id',
        'type',
        'url',
        'thumbnail_url',
        'filename',
        'size',
        'mime_type',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'size' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(ClassPost::class, 'post_id', 'id');
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrderedBySortOrder($query)
    {
        return $query->orderBy('sort_order');
    }
}
