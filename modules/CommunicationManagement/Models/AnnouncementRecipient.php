<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class AnnouncementRecipient extends Model
{
    use HasFactory;

    protected $table = 'announcement_recipients';

    protected $fillable = [
        'announcement_id',
        'user_id',
        'is_read',
        'read_at',
        'is_liked',
        'liked_at',
        'view_count',
        'last_viewed_at',
    ];

    protected $casts = [
        'announcement_id' => 'integer',
        'user_id' => 'integer',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_liked' => 'boolean',
        'liked_at' => 'datetime',
        'view_count' => 'integer',
        'last_viewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class, 'announcement_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Scopes
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeLiked($query)
    {
        return $query->where('is_liked', true);
    }

    public function scopeNotLiked($query)
    {
        return $query->where('is_liked', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForAnnouncement($query, $announcementId)
    {
        return $query->where('announcement_id', $announcementId);
    }

    public function scopeViewed($query)
    {
        return $query->where('view_count', '>', 0);
    }

    public function scopeNotViewed($query)
    {
        return $query->where('view_count', 0);
    }

    // Accessors
    public function getEngagementStatusAttribute(): string
    {
        if ($this->is_liked) {
            return 'liked';
        }

        if ($this->is_read) {
            return 'read';
        }

        if ($this->view_count > 0) {
            return 'viewed';
        }

        return 'unread';
    }

    public function getTimeAgoAttribute(): string
    {
        if ($this->read_at) {
            return $this->read_at->diffForHumans();
        }

        if ($this->last_viewed_at) {
            return $this->last_viewed_at->diffForHumans();
        }

        return $this->created_at->diffForHumans();
    }

    // Helper methods
    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function markAsViewed(): void
    {
        $this->update([
            'view_count' => $this->view_count + 1,
            'last_viewed_at' => now(),
        ]);

        // Auto-mark as read after viewing
        if (! $this->is_read) {
            $this->markAsRead();
        }
    }

    public function toggleLike(): bool
    {
        $isLiked = ! $this->is_liked;

        $this->update([
            'is_liked' => $isLiked,
            'liked_at' => $isLiked ? now() : null,
        ]);

        // Update announcement like count
        if ($isLiked) {
            $this->announcement->incrementLikeCount();
        } else {
            $this->announcement->decrementLikeCount();
        }

        return $isLiked;
    }

    public function like(): void
    {
        if (! $this->is_liked) {
            $this->update([
                'is_liked' => true,
                'liked_at' => now(),
            ]);

            $this->announcement->incrementLikeCount();
        }
    }

    public function unlike(): void
    {
        if ($this->is_liked) {
            $this->update([
                'is_liked' => false,
                'liked_at' => null,
            ]);

            $this->announcement->decrementLikeCount();
        }
    }

    public function getReadStatus(): array
    {
        return [
            'is_read' => $this->is_read,
            'read_at' => $this->read_at?->toISOString(),
            'is_liked' => $this->is_liked,
            'liked_at' => $this->liked_at?->toISOString(),
            'view_count' => $this->view_count,
            'last_viewed_at' => $this->last_viewed_at?->toISOString(),
            'engagement_status' => $this->engagement_status,
        ];
    }

    public static function createForUser($announcementId, $userId): self
    {
        return self::create([
            'announcement_id' => $announcementId,
            'user_id' => $userId,
            'is_read' => false,
            'is_liked' => false,
            'view_count' => 0,
        ]);
    }

    public static function getOrCreateForUser($announcementId, $userId): self
    {
        return self::firstOrCreate(
            [
                'announcement_id' => $announcementId,
                'user_id' => $userId,
            ],
            [
                'is_read' => false,
                'is_liked' => false,
                'view_count' => 0,
            ]
        );
    }
}
