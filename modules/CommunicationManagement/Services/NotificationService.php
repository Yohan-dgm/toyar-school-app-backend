<?php

namespace Modules\CommunicationManagement\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\CommunicationManagement\Models\Announcement;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;
use Modules\CommunicationManagement\Models\NotificationType;
use Modules\UserManagement\Models\User;
use App\Events\NotificationCreated;
use App\Events\NotificationRead;
use App\Events\NotificationStatsUpdated;
use App\Jobs\SendPushNotificationJob;
use Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData\GetNotificationUserTypeListDataAction;

class NotificationService
{
    /**
     * Send a notification to specified recipients
     */
    public function sendNotification(array $data): Notification
    {
        // Create the notification
        $notification = Notification::create([
            'notification_type_id' => $data['notification_type_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'priority' => $data['priority'] ?? 'normal',
            'target_type' => $data['target_type'],
            'target_data' => $data['target_data'] ?? null,
            'action_url' => $data['action_url'] ?? null,
            'action_text' => $data['action_text'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'school_id' => $data['school_id'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'created_by' => $data['created_by'],
            'is_active' => true,
        ]);

        // Determine recipients
        $recipients = $this->determineRecipients($data);

        // Create recipient records
        $this->createRecipientRecords($notification, $recipients);

        // Send immediately if not scheduled
        if (empty($data['is_scheduled'])) {
            $this->deliverNotification($notification);
        }

        return $notification;
    }

    /**
     * Schedule a notification for later delivery
     */
    public function scheduleNotification(array $data, Carbon $scheduledAt): Notification
    {
        $data['is_scheduled'] = true;
        $data['scheduled_at'] = $scheduledAt;

        return $this->sendNotification($data);
    }

    /**
     * Send a quick system notification
     */
    public function sendSystemNotification(string $title, string $message, array $recipients, string $priority = 'normal'): Notification
    {
        $systemType = NotificationType::where('slug', 'system')->first();

        return $this->sendNotification([
            'notification_type_id' => $systemType?->id ?? 1,
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'target_type' => 'user',
            'target_data' => ['user_ids' => $recipients],
            'created_by' => 1, // System user
        ]);
    }

    /**
     * Send a broadcast notification to all users
     */
    public function sendBroadcastNotification(string $title, string $message, ?int $typeId = null, string $priority = 'normal', int $createdBy = 1): Notification
    {
        return $this->sendNotification([
            'notification_type_id' => $typeId ?? 1,
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'target_type' => 'broadcast',
            'target_data' => [],
            'created_by' => $createdBy,
        ]);
    }

    /**
     * Send notification to users by role
     */
    public function sendRoleNotification(string $title, string $message, array $roles, ?int $typeId = null, string $priority = 'normal', int $createdBy = 1): Notification
    {
        return $this->sendNotification([
            'notification_type_id' => $typeId ?? 1,
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'target_type' => 'role',
            'target_data' => ['roles' => $roles],
            'created_by' => $createdBy,
        ]);
    }

    /**
     * Process scheduled notifications that are ready to send
     */
    public function processScheduledNotifications(): int
    {
        $notifications = Notification::readyToSend()->get();
        $processed = 0;

        foreach ($notifications as $notification) {
            $this->deliverNotification($notification);
            $processed++;
        }

        return $processed;
    }

    /**
     * Mark notifications as read for a user
     */
    public function markAsRead(int $userId, ?int $notificationId = null): int
    {
        $query = NotificationRecipient::where('user_id', $userId)
            ->where('is_read', false);

        if ($notificationId) {
            $query->where('notification_id', $notificationId);
        }

        // Get the recipients before updating to broadcast events
        $recipientsToUpdate = $query->with('notification')->get();

        $count = $query->update([
            'is_read' => true,
            'read_at' => Carbon::now(),
        ]);

        if ($count > 0) {
            // Broadcast read events for each updated notification
            $this->broadcastReadEvents($recipientsToUpdate, $userId);

            // Update notification statistics
            if ($notificationId) {
                $notification = Notification::find($notificationId);
                $notification?->updateStats();
            } else {
                // Update stats for all affected notifications
                $notificationIds = $recipientsToUpdate->pluck('notification_id')->unique();
                foreach ($notificationIds as $id) {
                    $notification = Notification::find($id);
                    $notification?->updateStats();
                }
            }
        }

        return $count;
    }

    /**
     * Broadcast read events for notifications
     */
    private function broadcastReadEvents(Collection $recipients, int $userId): void
    {
        try {
            $recipients->each(function (NotificationRecipient $recipient) {
                // Mark as read in memory for broadcasting
                $recipient->is_read = true;
                $recipient->read_at = Carbon::now();
                
                // Broadcast notification read event
                broadcast(new NotificationRead($recipient->notification, $recipient));
            });

            // Broadcast updated user stats
            $this->broadcastUserStats($userId);

        } catch (\Exception $e) {
            \Log::error('Failed to broadcast read events', [
                'user_id' => $userId,
                'recipient_count' => $recipients->count(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get user's unread notification count
     */
    public function getUnreadCount(int $userId): int
    {
        return NotificationRecipient::where('user_id', $userId)
            ->where('is_read', false)
            ->whereHas('notification', function ($query) {
                $query->where('is_active', true)
                    ->notExpired();
            })
            ->count();
    }

    /**
     * Get user's urgent unread notification count
     */
    public function getUrgentUnreadCount(int $userId): int
    {
        return NotificationRecipient::where('user_id', $userId)
            ->where('is_read', false)
            ->whereHas('notification', function ($query) {
                $query->where('is_active', true)
                    ->where('priority', 'urgent')
                    ->notExpired();
            })
            ->count();
    }

    /**
     * Clean up old notifications
     */
    public function cleanupOldNotifications(int $daysOld = 90): int
    {
        $cutoffDate = Carbon::now()->subDays($daysOld);

        // Soft delete old notifications
        $count = Notification::where('created_at', '<', $cutoffDate)
            ->whereNull('deleted_at')
            ->update(['deleted_at' => Carbon::now()]);

        return $count;
    }

    /**
     * Clean up expired notifications
     */
    public function cleanupExpiredNotifications(): int
    {
        return Notification::expired()
            ->whereNull('deleted_at')
            ->update(['deleted_at' => Carbon::now()]);
    }

    /**
     * Get notification statistics for admin dashboard
     */
    public function getNotificationStats(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);

        $stats = Notification::where('created_at', '>=', $startDate)
            ->selectRaw('
                COUNT(*) as total,
                SUM(total_recipients) as total_recipients,
                SUM(total_sent) as total_sent,
                SUM(total_delivered) as total_delivered,
                SUM(total_read) as total_read,
                SUM(CASE WHEN priority = \'urgent\' THEN 1 ELSE 0 END) as urgent,
                SUM(CASE WHEN priority = \'high\' THEN 1 ELSE 0 END) as high,
                SUM(CASE WHEN priority = \'normal\' THEN 1 ELSE 0 END) as normal,
                SUM(CASE WHEN sent_at IS NOT NULL THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN sent_at IS NULL THEN 1 ELSE 0 END) as pending
            ')
            ->first();

        return [
            'total_notifications' => (int) $stats->total,
            'total_recipients' => (int) $stats->total_recipients,
            'total_sent' => (int) $stats->total_sent,
            'total_delivered' => (int) $stats->total_delivered,
            'total_read' => (int) $stats->total_read,
            'by_priority' => [
                'urgent' => (int) $stats->urgent,
                'high' => (int) $stats->high,
                'normal' => (int) $stats->normal,
            ],
            'by_status' => [
                'sent' => (int) $stats->sent,
                'pending' => (int) $stats->pending,
            ],
            'delivery_rate' => $stats->total_sent > 0 ? round(($stats->total_delivered / $stats->total_sent) * 100, 2) : 0,
            'read_rate' => $stats->total_delivered > 0 ? round(($stats->total_read / $stats->total_delivered) * 100, 2) : 0,
        ];
    }

    /**
     * Determine recipients based on target type and data
     */
    private function determineRecipients(array $data): array
    {
        $targetData = $data['target_data'] ?? [];

        // If group_filter or student_id is set, use the specialized resolution action
        if (isset($targetData['group_filter']) || isset($targetData['student_id'])) {
            return GetNotificationUserTypeListDataAction::run($targetData, [])->pluck('id')->toArray();
        }

        $targetType = $data['target_type'];
        $schoolId = $data['school_id'] ?? null;

        return match ($targetType) {
            'broadcast' => $this->getBroadcastRecipients($schoolId),
            'user' => $this->getUserRecipients($targetData),
            'role' => $this->getRoleRecipients($targetData, $schoolId),
            'class' => $this->getClassRecipients($targetData, $schoolId),
            'grade' => $this->getGradeRecipients($targetData, $schoolId),
            'school' => $this->getSchoolRecipients($schoolId),
            default => []
        };
    }

    /**
     * Create recipient records for a notification
     */
    private function createRecipientRecords(Notification $notification, array $recipients): void
    {
        $recipientData = [];
        foreach ($recipients as $userId) {
            $recipientData[] = [
                'notification_id' => $notification->id,
                'user_id' => $userId,
                'is_read' => false,
                'is_delivered' => false,
                'delivery_method' => 'in_app',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if (! empty($recipientData)) {
            NotificationRecipient::insert($recipientData);
            $notification->update(['total_recipients' => count($recipients)]);
        }
    }

    /**
     * Deliver a notification immediately
     */
    private function deliverNotification(Notification $notification): void
    {
        // Mark notification as sent
        $notification->markAsSent();

        // Mark all recipients as delivered (for in-app notifications)
        $notification->recipients()->update([
            'is_delivered' => true,
            'delivered_at' => Carbon::now(),
        ]);

        // Update statistics
        $notification->updateStats();

        // Broadcast real-time events to all recipients
        $this->broadcastNotificationEvents($notification);

        // Dispatch push notification job (background processing)
        if ($this->shouldSendPushNotifications($notification)) {
            \Log::info('DEBUG: Dispatching SendPushNotificationJob', ['id' => $notification->id, 'priority' => $notification->priority]);
            SendPushNotificationJob::dispatch($notification);
        } else {
            \Log::info('DEBUG: Skipping Push Notification', ['id' => $notification->id, 'reason' => 'shouldSendPushNotifications returned false']);
        }
    }

    /**
     * Broadcast real-time events to notification recipients
     */
    private function broadcastNotificationEvents(Notification $notification): void
    {
        try {
            $notification->recipients->each(function (NotificationRecipient $recipient) use ($notification) {
                // Broadcast notification created event
                broadcast(new NotificationCreated($notification, $recipient));
                
                // Update user notification stats
                $this->broadcastUserStats($recipient->user_id);
            });
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast notification events', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Broadcast user notification stats update
     */
    private function broadcastUserStats(int $userId): void
    {
        try {
            $unreadCount = $this->getUnreadCount($userId);
            $urgentCount = $this->getUrgentUnreadCount($userId);
            
            broadcast(new NotificationStatsUpdated($userId, $unreadCount, $urgentCount));
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast user notification stats', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Determine if push notifications should be sent for this notification
     */
    private function shouldSendPushNotifications(Notification $notification): bool
    {
        // Don't send push for expired notifications
        if ($notification->is_expired) {
            return false;
        }

        // Don't send push if notification is inactive
        if (!$notification->is_active) {
            return false;
        }

        // You can add more business logic here
        // For example, check user preferences, notification type settings, etc.
        
        return true;
    }

    private function getBroadcastRecipients(?int $schoolId): array
    {
        return User::where('is_active', true)->pluck('id')->toArray();
    }

    private function getUserRecipients(array $targetData): array
    {
        if (isset($targetData['user_id'])) {
            return [$targetData['user_id']];
        }

        if (isset($targetData['user_ids']) && is_array($targetData['user_ids'])) {
            return User::whereIn('id', $targetData['user_ids'])
                ->where('is_active', true)
                ->pluck('id')
                ->toArray();
        }

        // Support student_id (new format)
        if (isset($targetData['student_id'])) {
            return User::whereHas('student_guardian_list.student', function($q) use ($targetData) {
                $q->where('id', $targetData['student_id']);
            })
            // Or if student is directly linked to user (most likely for student app)
            ->orWhereIn('id', function($q) use ($targetData) {
                $q->select('user_id')->from('student')->where('id', $targetData['student_id']);
            })
            ->where('is_active', true)
            ->pluck('id')
                ->toArray();
        }

        return [];
    }

    private function getRoleRecipients(array $targetData, ?int $schoolId): array
    {
        // This would need to be implemented based on your role system
        return [];
    }

    private function getClassRecipients(array $targetData, ?int $schoolId): array
    {
        $classIds = $targetData['grade_level_class_ids'] ?? [];
        if (isset($targetData['grade_level_class_id'])) {
            $classIds[] = $targetData['grade_level_class_id'];
        }

        if (empty($classIds)) {
            return [];
        }

        return User::whereIn('id', function($q) use ($classIds) {
            $q->select('user_id')->from('student')->whereIn('grade_level_class_id', $classIds);
        })
        ->where('is_active', true)
        ->pluck('id')
        ->toArray();
    }

    private function getGradeRecipients(array $targetData, ?int $schoolId): array
    {
        $gradeIds = $targetData['grade_level_ids'] ?? [];
        if (isset($targetData['grade_level_id'])) {
            $gradeIds[] = $targetData['grade_level_id'];
        }

        if (empty($gradeIds)) {
            return [];
        }

        return User::whereIn('id', function($q) use ($gradeIds) {
            $q->select('user_id')->from('student')->whereIn('grade_level_id', $gradeIds);
        })
        ->where('is_active', true)
        ->pluck('id')
        ->toArray();
    }

    private function getSchoolRecipients(int $schoolId): array
    {
        return User::where('is_active', true)->pluck('id')->toArray();
    }

    /**
     * Send notification for a published announcement
     */
    public function sendAnnouncementNotification(Announcement $announcement): ?Notification
    {
        try {
            // Get announcement notification type
            $announcementType = NotificationType::where('slug', 'announcement')->first();
            $typeId = $announcementType?->id ?? 2;

            // Convert priority level to notification priority
            $notificationPriority = match ($announcement->priority_level) {
                3 => 'urgent',
                2 => 'high',
                1 => 'normal',
                default => 'normal'
            };

            // Send notification
            $notification = $this->sendNotification([
                'notification_type_id' => $typeId,
                'title' => $announcement->title,
                'message' => $announcement->excerpt_or_content,
                'priority' => $notificationPriority,
                'target_type' => $announcement->target_type,
                'target_data' => $announcement->target_data,
                'action_url' => "/announcements/{$announcement->id}",
                'action_text' => 'View Announcement',
                'image_url' => $announcement->image_url,
                'school_id' => $announcement->school_id,
                'created_by' => $announcement->created_by,
            ]);

            // Mark notification as sent on announcement
            $announcement->markNotificationSent($notification->id);

            return $notification;

        } catch (\Exception $e) {
            \Log::error('Failed to send announcement notification', [
                'announcement_id' => $announcement->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Send notification for multiple announcements (batch)
     */
    public function sendBatchAnnouncementNotifications(Collection $announcements): array
    {
        $results = [];

        foreach ($announcements as $announcement) {
            $notification = $this->sendAnnouncementNotification($announcement);
            $results[] = [
                'announcement_id' => $announcement->id,
                'notification_id' => $notification?->id,
                'success' => $notification !== null,
            ];
        }

        return $results;
    }

    /**
     * Process scheduled announcements ready to be published
     */
    public function processScheduledAnnouncements(): int
    {
        $announcements = Announcement::readyToPublish()->get();
        $processed = 0;

        foreach ($announcements as $announcement) {
            // Publish the announcement
            if ($announcement->publish()) {
                // Send notification
                $this->sendAnnouncementNotification($announcement);
                $processed++;
            }
        }

        return $processed;
    }

    /**
     * Generic reusable method for sending notifications from any module
     */
    public function sendModuleNotification(string $title, string $message, array $recipients = [], string $type = 'system', string $priority = 'normal', ?string $actionUrl = null): Notification
    {
        // Get or create notification type
        $notificationType = NotificationType::where('slug', $type)->first();
        if (! $notificationType) {
            $notificationType = NotificationType::where('slug', 'system')->first();
        }

        // Determine target type and data based on recipients
        if (empty($recipients)) {
            $targetType = 'broadcast';
            $targetData = [];
        } else {
            $targetType = 'user';
            $targetData = ['user_ids' => $recipients];
        }

        return $this->sendNotification([
            'notification_type_id' => $notificationType?->id ?? 1,
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'target_type' => $targetType,
            'target_data' => $targetData,
            'action_url' => $actionUrl,
            'created_by' => 1, // System user
        ]);
    }
}
