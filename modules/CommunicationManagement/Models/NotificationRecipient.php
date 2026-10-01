<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class NotificationRecipient extends Model
{
    use HasFactory;

    protected $table = 'notification_recipients';

    protected $fillable = [
        'notification_id',
        'user_id',
        'is_read',
        'read_at',
        'is_delivered',
        'delivered_at',
        'delivery_method',
        'push_token',
        'push_sent',
        'push_sent_at',
        'push_error',
        'push_attempts',
        'email_sent',
        'email_sent_at',
        'sms_sent',
        'sms_sent_at',
        'failure_reason',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_delivered' => 'boolean',
        'delivered_at' => 'datetime',
        'push_sent' => 'boolean',
        'push_sent_at' => 'datetime',
        'push_attempts' => 'integer',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
        'sms_sent' => 'boolean',
        'sms_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id', 'id');
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

    public function scopeDelivered($query)
    {
        return $query->where('is_delivered', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_delivered', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForNotification($query, $notificationId)
    {
        return $query->where('notification_id', $notificationId);
    }

    public function scopeByDeliveryMethod($query, $method)
    {
        return $query->where('delivery_method', $method);
    }

    // Helper methods
    public function markAsRead()
    {
        if (! $this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function markAsDelivered($method = 'in_app')
    {
        if (! $this->is_delivered) {
            $this->update([
                'is_delivered' => true,
                'delivered_at' => now(),
                'delivery_method' => $method,
            ]);
        }
    }

    public function markPushSent($token = null)
    {
        $data = [
            'push_sent' => true,
            'push_sent_at' => now(),
        ];

        if ($token) {
            $data['push_token'] = $token;
        }

        $this->update($data);
    }

    public function markEmailSent()
    {
        $this->update([
            'email_sent' => true,
            'email_sent_at' => now(),
        ]);
    }

    public function markSmsSent()
    {
        $this->update([
            'sms_sent' => true,
            'sms_sent_at' => now(),
        ]);
    }

    public function getDeliveryStatusAttribute()
    {
        if (! $this->is_delivered) {
            return 'pending';
        }

        if ($this->is_read) {
            return 'read';
        }

        return 'delivered';
    }

    public function getTimeAgoAttribute()
    {
        if ($this->read_at) {
            return $this->read_at->diffForHumans();
        }

        if ($this->delivered_at) {
            return $this->delivered_at->diffForHumans();
        }

        return $this->created_at->diffForHumans();
    }
}
