<?php

namespace Modules\ActivityFeedManagement\Services;

use Illuminate\Support\Facades\Log;
use Modules\ActivityFeedManagement\Models\ActivityFeedNotificationSetting;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\SchoolPost;
use Modules\ActivityFeedManagement\Models\StudentPost;
use Modules\CommunicationManagement\Intents\Notification\CreateNotification\CreateNotificationAction;
use Modules\CommunicationManagement\Models\NotificationType;

/**
 * Sends a push notification (via the existing CreateNotificationAction /
 * ExpoPushNotificationService pipeline) when a School, Student, or Class
 * post is created. Never throws - a notification failure must not affect
 * the post that triggered it.
 */
class ActivityFeedPostNotificationService
{
    public static function forPost(string $section, int $postId): void
    {
        try {
            if (! ActivityFeedNotificationSetting::isEnabled($section)) {
                return;
            }

            [$post, $targetType, $targetData] = static::resolveTarget($section, $postId);

            if (! $post) {
                return;
            }

            $notificationTypeId = NotificationType::where('slug', 'social')->value('id');

            if (! $notificationTypeId) {
                Log::warning('Skipping activity feed push notification: "social" notification type not found', [
                    'section' => $section,
                    'post_id' => $postId,
                ]);

                return;
            }

            CreateNotificationAction::run(
                [
                    'notification_type_id' => $notificationTypeId,
                    'title' => $post->title,
                    'message' => $post->content ? substr($post->content, 0, 200) : $post->title,
                    'priority' => 'normal',
                    'target_type' => $targetType,
                    'target_data' => $targetData,
                    'action_url' => null,
                    'action_text' => null,
                    'image_url' => null,
                    'is_scheduled' => false,
                    'scheduled_at' => null,
                    'expires_at' => null,
                ],
                ['created_by' => $post->created_by]
            );
        } catch (\Throwable $e) {
            Log::error("Failed to send {$section} push notification", [
                'section' => $section,
                'post_id' => $postId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private static function resolveTarget(string $section, int $postId): array
    {
        return match ($section) {
            'school_post' => [SchoolPost::find($postId), 'broadcast', []],
            'student_post' => static::resolveStudentPostTarget($postId),
            'class_post' => static::resolveClassPostTarget($postId),
            default => [null, null, null],
        };
    }

    private static function resolveStudentPostTarget(int $postId): array
    {
        $post = StudentPost::find($postId);

        return [$post, 'user', ['student_id' => $post?->student_id]];
    }

    private static function resolveClassPostTarget(int $postId): array
    {
        $post = ClassPost::find($postId);

        return [$post, 'grade', [
            'group_filter' => 'Grade_Level_class',
            'grade_level_class_id' => $post?->class_id,
        ]];
    }
}
