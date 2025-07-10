<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityFeedHashtag extends Model
{
    use HasFactory;

    protected $table = 'activity_feed_hashtags';

    protected $fillable = [
        'post_id',
        'hashtag',
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

    // Scopes
    public function scopeByHashtag($query, $hashtag)
    {
        return $query->where('hashtag', $hashtag);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->select('hashtag')
                    ->selectRaw('COUNT(*) as usage_count')
                    ->groupBy('hashtag')
                    ->orderByDesc('usage_count')
                    ->limit($limit);
    }

    // Helper methods
    public static function extractHashtagsFromContent($content)
    {
        preg_match_all('/#([a-zA-Z0-9_]+)/', $content, $matches);
        return array_unique($matches[1]);
    }

    public static function createHashtagsForPost($postId, $content)
    {
        $hashtags = self::extractHashtagsFromContent($content);
        
        foreach ($hashtags as $hashtag) {
            self::create([
                'post_id' => $postId,
                'hashtag' => $hashtag,
            ]);
        }
        
        return $hashtags;
    }

    public static function updateHashtagsForPost($postId, $content)
    {
        // Delete existing hashtags for this post
        self::where('post_id', $postId)->delete();
        
        // Create new hashtags
        return self::createHashtagsForPost($postId, $content);
    }
}
