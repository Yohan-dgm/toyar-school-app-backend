<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class ActivityFeedPost extends Model
{
    use HasFactory;

    protected $table = 'activity_feed_posts';

    protected $fillable = [
        'type',
        'category',
        'title',
        'content',
        'author_id',
        'school_id',
        'class_id',
        'student_id',
        'likes_count',
        'comments_count',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ActivityFeedMedia::class, 'post_id', 'id')->orderBy('sort_order');
    }

    public function hashtags(): HasMany
    {
        return $this->hasMany(ActivityFeedHashtag::class, 'post_id', 'id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ActivityFeedLike::class, 'post_id', 'id');
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

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeSchoolWide($query)
    {
        return $query->whereNull('class_id')->whereNull('student_id');
    }

    public function scopeByDateRange($query, $dateFrom, $dateTo)
    {
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
        return $query;
    }

    public function scopeWithHashtags($query, array $hashtags)
    {
        return $query->whereHas('hashtags', function ($q) use ($hashtags) {
            $q->whereIn('hashtag', $hashtags);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'ILIKE', "%{$search}%")
              ->orWhere('content', 'ILIKE', "%{$search}%")
              ->orWhere('category', 'ILIKE', "%{$search}%");
        });
    }

    // Helper methods
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function getHashtagsArray()
    {
        return $this->hashtags->pluck('hashtag')->toArray();
    }
}
