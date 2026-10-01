<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;
use Modules\UserManagement\Models\User;
use App\Events\NotificationCreated;
use App\Events\NotificationStatsUpdated;
use App\Jobs\SendPushNotificationJob;

class CreateNotificationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createNotificationUserDTO = CreateNotificationUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createNotificationSystemDTO = CreateNotificationSystemDTO::validate($system_data);

        // Final Data Validation
        $createNotificationDTO = CreateNotificationDTO::validate(array_merge($createNotificationUserDTO, $createNotificationSystemDTO));

        // Create the notification
        $notification = Notification::create([
            'notification_type_id' => $createNotificationDTO['notification_type_id'],
            'title' => $createNotificationDTO['title'],
            'message' => $createNotificationDTO['message'],
            'priority' => $createNotificationDTO['priority'],
            'target_type' => $createNotificationDTO['target_type'],
            'target_data' => $createNotificationDTO['target_data'],
            'action_url' => $createNotificationDTO['action_url'],
            'action_text' => $createNotificationDTO['action_text'],
            'image_url' => $createNotificationDTO['image_url'],
            'is_scheduled' => $createNotificationDTO['is_scheduled'] ?? false,
            'scheduled_at' => $createNotificationDTO['scheduled_at'] ? Carbon::parse($createNotificationDTO['scheduled_at']) : null,
            'expires_at' => $createNotificationDTO['expires_at'] ? Carbon::parse($createNotificationDTO['expires_at']) : null,
            // 'school_id' => $createNotificationDTO['school_id'],
            'created_by' => $createNotificationDTO['created_by'],
            'is_active' => true,
        ]);

        // Determine recipients and create recipient records
        $recipients = $this->determineRecipients($createNotificationDTO);

        // Create notification recipients
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
        }

        // Update notification with recipient count
        $notification->update([
            'total_recipients' => count($recipients),
        ]);

        // If not scheduled, send immediately
        if (! $createNotificationDTO['is_scheduled']) {
            $this->sendNotification($notification);
        }

        // Prepare response data
        $responseData = [
            'id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'priority' => $notification->priority,
            'target_type' => $notification->target_type,
            'target_data' => $notification->target_data,
            'action_url' => $notification->action_url,
            'action_text' => $notification->action_text,
            'image_url' => $notification->image_url,
            'is_scheduled' => $notification->is_scheduled,
            'scheduled_at' => $notification->scheduled_at?->toISOString(),
            'sent_at' => $notification->sent_at?->toISOString(),
            'expires_at' => $notification->expires_at?->toISOString(),
            'total_recipients' => $notification->total_recipients,
            'is_active' => $notification->is_active,
            'created_at' => $notification->created_at->toISOString(),
        ];

        return CreateNotificationResDTO::fromArray($responseData);
    }

    private function determineRecipients(array $notificationData): array
    {
        $targetType = $notificationData['target_type'];
        $targetData = $notificationData['target_data'] ?? [];
        
        // This is a special handling where target_type might be "user", "broadcast", "role" etc. 
        // BUT the frontend might be sending the "group_filter" structure inside target_data 
        // to specify complex groups like "Grade_Level", "Primary" etc. as per user request.
        
        // Check if we need to use the robust resolution logic based on 'group_filter'
        if (isset($targetData['group_filter']) || isset($targetData['student_id'])) {
            return $this->resolveComplexRecipients($targetData);
        }

        // Fallback to standard simple handling if 'group_filter' isn't present
        return match ($targetType) {
            'broadcast' => $this->getBroadcastRecipients(null),
            'user' => $this->getUserRecipients($targetData),
            'role' => $this->getRoleRecipients($targetData),
            'class' => $this->getClassRecipients($targetData),
            'grade' => $this->getGradeRecipients($targetData),
            default => []
        };
    }

    private function resolveComplexRecipients(array $data): array {
        // Reuse logic pattern from GetNotificationUserTypeListDataAction
        
        // Case: Individual Student (resolve to parents/guardians)
        if (isset($data['student_id'])) {
            $student = \Modules\StudentManagement\Models\Student::select('father_id', 'mother_id', 'guardian_id')
                ->where('id', $data['student_id'])
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->first();

            if (!$student) return [];

            $guardianIds = collect([$student->father_id, $student->mother_id, $student->guardian_id])
                ->filter()->unique();

            if ($guardianIds->isEmpty()) return [];

            return \Modules\ParentManagement\Models\StudentGuardian::whereIn('id', $guardianIds)
                ->pluck('user_id')
                ->filter()->unique()->values()->toArray();
        }

        $groupFilter = $data['group_filter'] ?? 'All';

        $query = User::where('is_active', true);

        if ($groupFilter === 'All') {
            // No additional filter needed
        } elseif ($groupFilter === 'Educator') {
            $query->where('user_category', 2);
        } elseif ($groupFilter === 'Management') {
            $query->where('user_category', 4);
        } elseif ($groupFilter === 'Grade_Level') {
            $gradeLevelId = $data['grade_level_id'] ?? null;
            if ($gradeLevelId) {
                $userIds = $this->getGuardianUserIdsByStudentQuery(function($q) use ($gradeLevelId) {
                    $q->where('grade_level_id', $gradeLevelId);
                });
                $query->whereIn('id', $userIds);
            } else {
                return [];
            }
        } elseif ($groupFilter === 'Grade_Level_class') {
            $classId = $data['grade_level_class_id'] ?? null;
            if ($classId) {
                $userIds = $this->getGuardianUserIdsByStudentQuery(function($q) use ($classId) {
                    $q->where('grade_level_class_id', $classId);
                });
                $query->whereIn('id', $userIds);
            } else {
                return [];
            }
        } elseif (in_array($groupFilter, ['Early_Years', 'Primary', 'Secondary'])) {
            $gradeLevelGroups = [
                'Early_Years' => [13, 14, 15],
                'Primary' => [1, 2, 3, 4, 5],
                'Secondary' => [6, 7, 8, 9, 10, 11, 12],
            ];
            $gradeLevelIds = $gradeLevelGroups[$groupFilter] ?? [];
            if (!empty($gradeLevelIds)) {
                $userIds = $this->getGuardianUserIdsByStudentQuery(function($q) use ($gradeLevelIds) {
                    $q->whereIn('grade_level_id', $gradeLevelIds);
                });
                $query->whereIn('id', $userIds);
            } else {
                return [];
            }
        }

        return $query->pluck('id')->toArray();
    }

    private function getGuardianUserIdsByStudentQuery(callable $callback): array {
        // Helper to find students -> guardians -> user_ids
        $studentQuery = \Modules\StudentManagement\Models\Student::where('has_dropped_out', false)
            ->where('is_school_leaver', false)
            ->select('father_id', 'mother_id', 'guardian_id');
        
        $callback($studentQuery);
        
        $students = $studentQuery->get();

        $guardianIds = $students->flatMap(function ($student) {
            return [$student->father_id, $student->mother_id, $student->guardian_id];
        })->filter()->unique();

        if ($guardianIds->isEmpty()) return [];

        return \Modules\ParentManagement\Models\StudentGuardian::whereIn('id', $guardianIds)
            ->pluck('user_id')
            ->filter()->unique()->values()->toArray();
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
        return [];
    }

    private function getRoleRecipients(array $targetData): array
    {
        // Fallback basic implementation
        return [];
    }

    private function getClassRecipients(array $targetData): array
    {
        // Fallback basic implementation
        return [];
    }

    private function getGradeRecipients(array $targetData): array
    {
        // Fallback basic implementation
        return [];
    }

    private function sendNotification(Notification $notification): void
    {
        // Mark notification as sent
        $notification->markAsSent();

        // Mark all recipients as delivered (for in-app notifications)
        $notification->recipients()->update([
            'is_delivered' => true,
            'delivered_at' => Carbon::now(),
        ]);

        // Update notification statistics
        $notification->updateStats();

        // Broadcast real-time events to all recipients
        $this->broadcastNotificationEvents($notification);

        // Dispatch push notification job (background processing)
        if ($this->shouldSendPushNotifications($notification)) {
            SendPushNotificationJob::dispatch($notification);
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
            // Calculate unread counts
            $unreadCount = NotificationRecipient::where('user_id', $userId)
                ->where('is_read', false)
                ->whereHas('notification', function ($query) {
                    $query->where('is_active', true)
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhere('expires_at', '>=', now());
                        });
                })
                ->count();

            $urgentCount = NotificationRecipient::where('user_id', $userId)
                ->where('is_read', false)
                ->whereHas('notification', function ($query) {
                    $query->where('is_active', true)
                        ->where('priority', 'urgent')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhere('expires_at', '>=', now());
                        });
                })
                ->count();
            
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
        if ($notification->expires_at && $notification->expires_at->isPast()) {
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
}
