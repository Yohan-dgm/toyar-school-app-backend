<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class ActivityFeedLike extends Model
{
    use HasFactory;

    protected $table = 'activity_feed_likes';

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(ActivityFeedPost::class, 'post_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Scopes
    public function scopeByPost($query, $postId)
    {
        return $query->where('post_id', $postId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Helper methods
    public static function toggleLike($postId, $userId)
    {
        $like = self::where('post_id', $postId)->where('user_id', $userId)->first();
        
        if ($like) {
            // Unlike - remove the like
            $like->delete();
            
            // Decrement likes count
            ActivityFeedPost::where('id', $postId)->decrement('likes_count');
            
            return [
                'is_liked' => false,
                'likes_count' => ActivityFeedPost::find($postId)->likes_count
            ];
        } else {
            // Like - create new like
            self::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            
            // Increment likes count
            ActivityFeedPost::where('id', $postId)->increment('likes_count');
            
            return [
                'is_liked' => true,
                'likes_count' => ActivityFeedPost::find($postId)->likes_count
            ];
        }
    }

    public static function isLikedByUser($postId, $userId)
    {
        return self::where('post_id', $postId)->where('user_id', $userId)->exists();
    }

    public static function getLikesCount($postId)
    {
        return self::where('post_id', $postId)->count();
    }
}
