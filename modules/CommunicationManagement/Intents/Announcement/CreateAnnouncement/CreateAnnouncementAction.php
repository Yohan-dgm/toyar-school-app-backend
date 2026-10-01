<?php

namespace Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Announcement;
use Modules\CommunicationManagement\Models\AnnouncementRecipient;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Services\NotificationService;
use Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData\GetNotificationUserTypeListDataAction;
use Modules\UserManagement\Models\User;

class CreateAnnouncementAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createAnnouncementUserDTO = CreateAnnouncementUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createAnnouncementSystemDTO = CreateAnnouncementSystemDTO::validate($system_data);

        // Final Data Validation
        $createAnnouncementDTO = CreateAnnouncementDTO::validate(array_merge($createAnnouncementUserDTO, $createAnnouncementSystemDTO));

        // Normalize data for DB storage (map custom types to standard types)
        $normalizedData = $this->normalizeTargetData($createAnnouncementDTO instanceof \Spatie\LaravelData\Data ? $createAnnouncementDTO->toArray() : $createAnnouncementDTO);

        // Auto-generate excerpt if not provided
        $excerpt = $normalizedData['excerpt'] ?? null;
        if (! $excerpt) {
            $excerpt = $this->generateExcerpt($normalizedData['content']);
        }

        // PRIORITY 1: Create notification first (required)
        $notification = $this->createNotificationRecord($normalizedData, $excerpt);

        // PRIORITY 2: Optionally create announcement (secondary)
        $announcement = null;
        $saveAnnouncement = $normalizedData['save_announcement'] ?? true; // Default: true for backward compatibility
        
        if ($saveAnnouncement) {
            $announcement = $this->createAnnouncementRecord($normalizedData, $excerpt, $notification);
        }

        // Handle publishing logic (based on notification status)
        if ($normalizedData['status'] === 'published') {
            $this->handlePublishing($notification, $announcement);
        }

        // Prepare response data (notification-centric)
        $responseData = $this->formatNotificationResponse($notification, $announcement);

        return CreateAnnouncementResDTO::fromArray($responseData);
    }

    private function normalizeTargetData(array $data): array
    {
        $originalType = $data['target_type'] ?? 'broadcast';

        $map = [
            'All' => 'broadcast',
            'Student' => 'user',
            'Grade_Level' => 'grade',
            'Grade_Level_class' => 'class',
            'Educator' => 'role',
            'Management' => 'role',
            'Primary' => 'grade',
            'Secondary' => 'grade',
            'Early_Years' => 'grade',
        ];

        // If it's one of our custom types, map it
        if (isset($map[$originalType])) {
            $data['target_type'] = $map[$originalType];

            // Ensure target_data exists
            if (!isset($data['target_data'])) {
                $data['target_data'] = [];
            }

            // Store original type as group_filter if not already set
            if (!isset($data['target_data']['group_filter']) && $originalType !== 'Student') {
                $data['target_data']['group_filter'] = $originalType;
            }
        }

        return $data;
    }

    private function generateExcerpt(string $content, int $length = 150): string
    {
        $plainText = strip_tags($content);
        if (strlen($plainText) <= $length) {
            return $plainText;
        }

        return rtrim(substr($plainText, 0, $length)).'...';
    }

    /**
     * Create notification record first (required)
     */
    private function createNotificationRecord(array $data, string $excerpt): Notification
    {
        $notificationService = app(NotificationService::class);

        // Convert priority level to notification priority
        $notificationPriority = match ($data['priority_level']) {
            3 => 'urgent',
            2 => 'high',
            1 => 'normal',
            default => 'normal'
        };

        // Prepare notification data
        $notificationData = [
            'notification_type_id' => 1, // Announcement type
            'title' => $data['title'],
            'message' => $excerpt,
            'priority' => $notificationPriority,
            'target_type' => $data['target_type'] ?? 'broadcast',
            'target_data' => $data['target_data'] ?? [],
            'action_url' => null, // Will be set after announcement creation if needed
            'action_text' => 'View Announcement',
            'image_url' => $data['image_url'] ?? null,
            'created_by' => $data['created_by'],
            'is_scheduled' => ($data['status'] === 'scheduled'),
            'scheduled_at' => isset($data['scheduled_at']) ? Carbon::parse($data['scheduled_at']) : null,
            'expires_at' => isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : null,
            'metadata' => [
                'source' => 'announcement',
                'announcement_category_id' => $data['category_id'],
                'announcement_status' => $data['status'],
                'is_featured' => $data['is_featured'] ?? false,
                'is_pinned' => $data['is_pinned'] ?? false,
                'tags' => $data['tags'] ?? null,
                'meta_data' => $data['meta_data'] ?? null,
            ]
        ];

        // Create notification with recipients and push notifications
        return $notificationService->sendNotification($notificationData);
    }

    /**
     * Create announcement record (optional)
     */
    private function createAnnouncementRecord(array $data, string $excerpt, Notification $notification): ?Announcement
    {
        try {
            $announcement = Announcement::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'excerpt' => $excerpt,
                'category_id' => $data['category_id'],
                'priority_level' => $data['priority_level'],
                'status' => $data['status'],
                'target_type' => $data['target_type'] ?? 'broadcast',
                'target_data' => $data['target_data'] ?? null,
                'image_url' => $data['image_url'] ?? null,
                'attachment_urls' => $data['attachment_urls'] ?? null,
                'is_featured' => $data['is_featured'] ?? false,
                'is_pinned' => $data['is_pinned'] ?? false,
                'scheduled_at' => isset($data['scheduled_at']) ? Carbon::parse($data['scheduled_at']) : null,
                'expires_at' => isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : null,
                'tags' => $data['tags'] ?? null,
                'meta_data' => $data['meta_data'] ?? null,
                'created_by' => $data['created_by'],
                'view_count' => 0,
                'like_count' => 0,
                'notification_sent' => true, // Already sent via notification
                'notification_id' => $notification->id,
            ]);

            // Update notification with announcement reference
            $notification->update([
                'action_url' => "/announcements/{$announcement->id}",
                'metadata' => array_merge($notification->metadata ?? [], [
                    'announcement_id' => $announcement->id
                ])
            ]);

            // Create announcement recipients if needed
            $this->createRecipientRecords($announcement);

            return $announcement;

        } catch (\Exception $e) {
            \Log::error('Failed to create announcement record', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage(),
            ]);
            
            // Don't fail the entire operation if announcement creation fails
            return null;
        }
    }

    private function handlePublishing(Notification $notification, ?Announcement $announcement = null): void
    {
        // Set published_at timestamp for announcement if it exists
        if ($announcement) {
            $announcement->update([
                'published_at' => Carbon::now(),
            ]);
        }

        // Update notification metadata to mark as published
        $metadata = $notification->metadata ?? [];
        $metadata['published_at'] = Carbon::now()->toISOString();
        $notification->update(['metadata' => $metadata]);

        // Push notifications are already sent by NotificationService during creation
        // No additional push logic needed here since notifications table drives everything
    }

    /**
     * Format notification-centric response
     */
    private function formatNotificationResponse(Notification $notification, ?Announcement $announcement = null): array
    {
        $response = [
            // Primary notification data
            'id' => $notification->id,
            'notification_id' => $notification->id,
            'title' => $notification->title ?? '',
            'message' => $notification->message ?? '',
            'priority' => $notification->priority ?? 'normal',
            'target_type' => $notification->target_type ?? 'broadcast',
            'target_data' => $notification->target_data ?? [],
            'action_url' => $notification->action_url,
            'action_text' => $notification->action_text ?? 'View',
            'image_url' => $notification->image_url,
            'is_scheduled' => $notification->is_scheduled ?? false,
            'scheduled_at' => $notification->scheduled_at?->toISOString(),
            'sent_at' => $notification->sent_at?->toISOString(),
            'expires_at' => $notification->expires_at?->toISOString(),
            'total_recipients' => $notification->total_recipients ?? 0,
            'is_active' => $notification->is_active ?? true,
            'metadata' => $notification->metadata ?? [],
            'created_at' => $notification->created_at->toISOString(),
            
            // Notification status flags
            'notification_sent' => true, // Always true since notification was created
            'push_notifications_sent' => $notification->sent_at !== null,
        ];

        // Add optional announcement data if it exists
        if ($announcement) {
            $announcement->load(['category', 'createdBy']);
            
            $response['announcement'] = [
                'id' => $announcement->id,
                'content' => $announcement->content,
                'excerpt' => $announcement->excerpt,
                'category' => [
                    'id' => $announcement->category?->id,
                    'name' => $announcement->category?->name,
                    'slug' => $announcement->category?->slug,
                    'color' => $announcement->category?->color,
                    'icon' => $announcement->category?->icon,
                ],
                'priority_level' => $announcement->priority_level,
                'priority_label' => $announcement->priority_label,
                'priority_color' => $announcement->priority_color,
                'status' => $announcement->status,
                'status_label' => $announcement->status_label,
                'status_color' => $announcement->status_color,
                'target_display' => $announcement->target_display,
                'attachment_urls' => $announcement->attachment_urls,
                'is_featured' => $announcement->is_featured,
                'is_pinned' => $announcement->is_pinned,
                'published_at' => $announcement->published_at?->toISOString(),
                'view_count' => $announcement->view_count,
                'like_count' => $announcement->like_count,
                'tags_array' => $announcement->tags_array,
                'meta_data' => $announcement->meta_data,
                'creator' => [
                    'id' => $announcement->createdBy?->id,
                    'name' => $announcement->createdBy?->full_name,
                    'username' => $announcement->createdBy?->username,
                ],
                'announcement_created_at' => $announcement->created_at->toISOString(),
            ];
        } else {
            $response['announcement'] = null;
        }

        return $response;
    }

    private function createRecipientRecords(Announcement $announcement): void
    {
        // Determine recipients based on target type
        $recipients = $this->determineRecipients($announcement);

        // Create recipient records
        $recipientData = [];
        foreach ($recipients as $userId) {
            $recipientData[] = [
                'announcement_id' => $announcement->id,
                'user_id' => $userId,
                'is_read' => false,
                'is_liked' => false,
                'view_count' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if (! empty($recipientData)) {
            AnnouncementRecipient::insert($recipientData);
        }
    }

    private function determineRecipients(Announcement $announcement): array
    {
        $targetData = $announcement->target_data ?? [];

        // If group_filter or student_id is set, use the specialized resolution action
        if (isset($targetData['group_filter']) || isset($targetData['student_id'])) {
            return GetNotificationUserTypeListDataAction::run($targetData, [])->pluck('id')->toArray();
        }

        $targetType = $announcement->target_type;
        // $schoolId = $announcement->school_id;

        return match ($targetType) {
            'broadcast' => $this->getBroadcastRecipients(null),
            'user' => $this->getUserRecipients($targetData),
            'role' => $this->getRoleRecipients($targetData, null),
            'class' => $this->getClassRecipients($targetData, null),
            'grade' => $this->getGradeRecipients($targetData, null),
            // 'school' => $this->getSchoolRecipients($schoolId),
            default => $this->getBroadcastRecipients(null)
        };
    }

    private function getBroadcastRecipients(?int $schoolId): array
    {
        // Get all active users for broadcast announcements
        $query = User::query();
        
        // Add is_active filter if column exists
        $schema = DB::connection()->getSchemaBuilder();
        if ($schema->hasColumn('user', 'is_active')) {
            $query->where('is_active', true);
        }
        
        // Add school filter if provided and column exists
        if ($schoolId && $schema->hasColumn('user', 'school_id')) {
            $query->where('school_id', $schoolId);
        }
        
        return $query->pluck('id')->toArray();
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
            return User::whereIn('id', function($q) use ($targetData) {
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

    // private function getSchoolRecipients(int $schoolId): array
    // {
    //     return User::where('is_active', true)->pluck('id')->toArray();
    // }

    private function formatAnnouncementResponse(Announcement $announcement): array
    {
        return [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'content' => $announcement->content,
            'excerpt' => $announcement->excerpt,
            'category' => [
                'id' => $announcement->category?->id,
                'name' => $announcement->category?->name,
                'slug' => $announcement->category?->slug,
                'color' => $announcement->category?->color,
                'icon' => $announcement->category?->icon,
            ],
            'priority_level' => $announcement->priority_level,
            'priority_label' => $announcement->priority_label,
            'priority_color' => $announcement->priority_color,
            'status' => $announcement->status,
            'status_label' => $announcement->status_label,
            'status_color' => $announcement->status_color,
            'target_type' => $announcement->target_type,
            'target_display' => $announcement->target_display,
            'target_data' => $announcement->target_data,
            'image_url' => $announcement->image_url,
            'attachment_urls' => $announcement->attachment_urls,
            'is_featured' => $announcement->is_featured,
            'is_pinned' => $announcement->is_pinned,
            'scheduled_at' => $announcement->scheduled_at?->toISOString(),
            'published_at' => $announcement->published_at?->toISOString(),
            'expires_at' => $announcement->expires_at?->toISOString(),
            'view_count' => $announcement->view_count,
            'like_count' => $announcement->like_count,
            'notification_sent' => $announcement->notification_sent,
            'tags_array' => $announcement->tags_array,
            'meta_data' => $announcement->meta_data,
            'creator' => [
                'id' => $announcement->createdBy?->id,
                'name' => $announcement->createdBy?->full_name,
                'username' => $announcement->createdBy?->username,
            ],
            'created_at' => $announcement->created_at->toISOString(),
        ];
    }
}
