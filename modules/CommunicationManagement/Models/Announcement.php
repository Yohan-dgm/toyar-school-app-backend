<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\UserManagement\Models\User;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'category_id',
        'priority_level',
        'status',
        'target_type',
        'target_data',
        'image_url',
        'attachment_urls',
        'is_featured',
        'is_pinned',
        'scheduled_at',
        'published_at',
        'expires_at',
        'view_count',
        'like_count',
        // 'school_id',
        'notification_sent',
        'notification_id',
        'tags',
        'meta_data',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'priority_level' => 'integer',
        'target_data' => 'array',
        'attachment_urls' => 'array',
        'is_featured' => 'boolean',
        'is_pinned' => 'boolean',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'view_count' => 'integer',
        'like_count' => 'integer',
        // 'school_id' => 'integer',
        'notification_sent' => 'boolean',
        'notification_id' => 'integer',
        'meta_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id', 'id');
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id', 'id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(AnnouncementRecipient::class, 'announcement_id', 'id');
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
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->whereNotNull('scheduled_at');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['published', 'scheduled']);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority_level', $priority);
    }

    public function scopeByTargetType($query, $targetType)
    {
        return $query->where('target_type', $targetType);
    }

    // public function scopeBySchool($query, $schoolId)
    // {
    //     return $query->where('school_id', $schoolId);
    // }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'ILIKE', "%{$search}%")
                ->orWhere('content', 'ILIKE', "%{$search}%")
                ->orWhere('excerpt', 'ILIKE', "%{$search}%")
                ->orWhere('tags', 'ILIKE', "%{$search}%");
        });
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('published_at', '>=', now()->subDays($days));
    }

    public function scopeReadyToPublish($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '<=', now());
    }

    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority_level', 'desc')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('is_featured', 'desc');
    }

    public function scopeOrderByPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' && ! is_null($this->published_at);
    }

    public function getIsDraftAttribute(): bool
    {
        return $this->status === 'draft';
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->status === 'scheduled' && ! is_null($this->scheduled_at);
    }

    public function getIsArchivedAttribute(): bool
    {
        return $this->status === 'archived';
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority_level) {
            3 => 'High',
            2 => 'Medium',
            1 => 'Low',
            default => 'Low'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority_level) {
            3 => '#ef4444', // Red
            2 => '#f59e0b', // Amber
            1 => '#6b7280', // Gray
            default => '#6b7280'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'published' => 'Published',
            'scheduled' => 'Scheduled',
            'draft' => 'Draft',
            'archived' => 'Archived',
            default => 'Unknown'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'published' => '#10b981', // Green
            'scheduled' => '#f59e0b',  // Amber
            'draft' => '#6b7280',      // Gray
            'archived' => '#64748b',   // Slate
            default => '#6b7280'
        };
    }

    public function getTargetDisplayAttribute(): string
    {
        return match ($this->target_type) {
            'broadcast' => 'All Users',
            'role' => 'Specific Roles',
            'class' => 'Specific Classes',
            'grade' => 'Specific Grades',
            'user' => 'Specific Users',
            // 'school' => 'School-wide',
            default => 'Unknown'
        };
    }

    public function getExcerptOrContentAttribute(): string
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        return Str::limit(strip_tags($this->content), 150);
    }

    public function getReadTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));

        return max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
    }

    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->published_at?->format('M d, Y \a\t g:i A');
    }

    public function getTimeAgoAttribute(): ?string
    {
        return $this->published_at?->diffForHumans();
    }

    public function getTagsArrayAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }

        return array_map('trim', explode(',', $this->tags));
    }

    public function getAttachmentCountAttribute(): int
    {
        return count($this->attachment_urls ?? []);
    }

    public function getHasAttachmentsAttribute(): bool
    {
        return $this->attachment_count > 0;
    }

    public function getHasImageAttribute(): bool
    {
        return ! empty($this->image_url);
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function archive(): bool
    {
        return $this->update([
            'status' => 'archived',
        ]);
    }

    public function schedule($scheduledAt): bool
    {
        return $this->update([
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt,
        ]);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function incrementLikeCount(): void
    {
        $this->increment('like_count');
    }

    public function decrementLikeCount(): void
    {
        $this->decrement('like_count');
    }

    public function isReadByUser($userId): bool
    {
        return $this->recipients()
            ->where('user_id', $userId)
            ->where('is_read', true)
            ->exists();
    }

    public function isLikedByUser($userId): bool
    {
        return $this->recipients()
            ->where('user_id', $userId)
            ->where('is_liked', true)
            ->exists();
    }

    public function getRecipientForUser($userId)
    {
        return $this->recipients()
            ->where('user_id', $userId)
            ->first();
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }

    public function canBePublished(): bool
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }

    public function canBeArchived(): bool
    {
        return $this->status === 'published';
    }

    public function canBeDeleted(): bool
    {
        return in_array($this->status, ['draft', 'archived']);
    }

    public function shouldSendNotification(): bool
    {
        return $this->is_published && ! $this->notification_sent;
    }

    public function markNotificationSent($notificationId = null): void
    {
        $this->update([
            'notification_sent' => true,
            'notification_id' => $notificationId,
        ]);
    }

    public static function getPriorityOptions(): array
    {
        return [
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'scheduled' => 'Scheduled',
            'published' => 'Published',
            'archived' => 'Archived',
        ];
    }

    public static function getTargetTypeOptions(): array
    {
        return [
            'broadcast' => 'All Users',
            'role' => 'Specific Roles',
            'class' => 'Specific Classes',
            'grade' => 'Specific Grades',
            'user' => 'Specific Users',
            // 'school' => 'School-wide',
        ];
    }
}
