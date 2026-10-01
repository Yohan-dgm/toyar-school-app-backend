<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\UserManagement\Models\User;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'notification_type_id',
        'title',
        'message',
        'priority',
        'target_type',
        'target_data',
        'action_url',
        'action_text',
        'image_url',
        'is_scheduled',
        'scheduled_at',
        'sent_at',
        'expires_at',
        'school_id',
        'metadata',
        'total_recipients',
        'total_sent',
        'total_delivered',
        'total_read',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'target_data' => 'array',
        'metadata' => 'array',
        'is_scheduled' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'expires_at' => 'datetime',
        'total_recipients' => 'integer',
        'total_sent' => 'integer',
        'total_delivered' => 'integer',
        'total_read' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id', 'id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class, 'notification_id', 'id');
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

    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('sent_at');
    }

    public function scopeScheduled($query)
    {
        return $query->where('is_scheduled', true);
    }

    public function scopeReadyToSend($query)
    {
        return $query->where('is_scheduled', true)
            ->where('scheduled_at', '<=', now())
            ->whereNull('sent_at')
            ->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<', now());
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
        });
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByTargetType($query, $targetType)
    {
        return $query->where('target_type', $targetType);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('notification_type_id', $typeId);
    }

    // public function scopeBySchool($query, $schoolId)
    // {
    //     return $query->where('school_id', $schoolId);
    // }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('recipients', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeUnreadForUser($query, $userId)
    {
        return $query->whereHas('recipients', function ($q) use ($userId) {
            $q->where('user_id', $userId)
                ->where('is_read', false);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'ILIKE', "%{$search}%")
                ->orWhere('message', 'ILIKE', "%{$search}%");
        });
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Accessors
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsSentAttribute()
    {
        return ! is_null($this->sent_at);
    }

    public function getIsPendingAttribute()
    {
        return is_null($this->sent_at);
    }

    public function getDeliveryRateAttribute()
    {
        if ($this->total_sent === 0) {
            return 0;
        }

        return round(($this->total_delivered / $this->total_sent) * 100, 2);
    }

    public function getReadRateAttribute()
    {
        if ($this->total_delivered === 0) {
            return 0;
        }

        return round(($this->total_read / $this->total_delivered) * 100, 2);
    }

    public function getPriorityLabelAttribute()
    {
        return match ($this->priority) {
            'urgent' => 'Urgent',
            'high' => 'High Priority',
            'normal' => 'Normal',
            default => 'Normal'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match ($this->priority) {
            'urgent' => '#ef4444',
            'high' => '#f59e0b',
            'normal' => '#6b7280',
            default => '#6b7280'
        };
    }

    public function getTargetDisplayAttribute()
    {
        return match ($this->target_type) {
            'broadcast' => 'All Users',
            'user' => 'Single User',
            'role' => 'Role-based',
            'class' => 'Class-based',
            'grade' => 'Grade-based',
            // 'school' => 'School-wide',
            default => 'Unknown'
        };
    }

    // Helper methods
    public function markAsSent()
    {
        $this->update([
            'sent_at' => now(),
        ]);
    }

    public function updateStats()
    {
        $totalSent = $this->recipients()->count();
        $totalDelivered = $this->recipients()->where('is_delivered', true)->count();
        $totalRead = $this->recipients()->where('is_read', true)->count();

        $this->update([
            'total_sent' => $totalSent,
            'total_delivered' => $totalDelivered,
            'total_read' => $totalRead,
        ]);
    }

    public function isReadByUser($userId)
    {
        return $this->recipients()
            ->where('user_id', $userId)
            ->where('is_read', true)
            ->exists();
    }

    public function getRecipientForUser($userId)
    {
        return $this->recipients()
            ->where('user_id', $userId)
            ->first();
    }

    public function canBeDeleted()
    {
        return $this->created_at->diffInDays() > 30 || $this->is_expired;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y \a\t g:i A');
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
