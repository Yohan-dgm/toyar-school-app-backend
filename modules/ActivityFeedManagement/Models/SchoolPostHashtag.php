<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class SchoolPostHashtag extends Model
{
    use HasFactory;

    protected $table = 'school_post_hashtags';

    protected $fillable = [
        'hashtag',
        'post_id',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(SchoolPost::class, 'post_id', 'id');
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

    public function scopeByHashtag($query, $hashtag)
    {
        return $query->where('hashtag', $hashtag);
    }
}
