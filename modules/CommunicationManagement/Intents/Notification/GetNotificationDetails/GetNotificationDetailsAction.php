<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class GetNotificationDetailsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getNotificationDetailsUserDTO = GetNotificationDetailsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $getNotificationDetailsSystemDTO = GetNotificationDetailsSystemDTO::validate($system_data);

        // Final Data Validation
        $getNotificationDetailsDTO = GetNotificationDetailsDTO::validate(array_merge($getNotificationDetailsUserDTO, $getNotificationDetailsSystemDTO));

        $userId = $getNotificationDetailsDTO['user_id'];
        $notificationId = $getNotificationDetailsDTO['notification_id'];

        // Get notification with all related data
        $notification = Notification::with(['notificationType', 'createdBy'])
            ->find($notificationId);

        if (! $notification) {
            throw new \Exception('Notification not found');
        }

        // Check if user has access to this notification
        $userNotification = NotificationRecipient::where('notification_id', $notificationId)
            ->where('user_id', $userId)
            ->first();

        if (! $userNotification) {
            throw new \Exception('You do not have access to this notification');
        }

        // Auto-mark as read when user views details (if not already read)
        if (! $userNotification->is_read) {
            $userNotification->markAsRead();
            $notification->updateStats();
        }

        // Prepare response data
        $responseData = [
            'id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'priority' => $notification->priority,
            'priority_label' => $notification->priority_label,
            'priority_color' => $notification->priority_color,
            'type' => [
                'id' => $notification->notificationType?->id,
                'name' => $notification->notificationType?->name,
                'slug' => $notification->notificationType?->slug,
                'icon' => $notification->notificationType?->icon ?? 'bell',
                'color' => $notification->notificationType?->color ?? '#6b7280',
            ],
            'target_type' => $notification->target_type,
            'target_display' => $notification->target_display,
            'target_data' => $notification->target_data,
            'action_url' => $notification->action_url,
            'action_text' => $notification->action_text,
            'image_url' => $notification->image_url,
            'is_read' => $userNotification->is_read,
            'read_at' => $userNotification->read_at?->toISOString(),
            'is_delivered' => $userNotification->is_delivered,
            'delivered_at' => $userNotification->delivered_at?->toISOString(),
            'expires_at' => $notification->expires_at?->toISOString(),
            'is_expired' => $notification->is_expired,
            'stats' => [
                'total_recipients' => $notification->total_recipients,
                'total_sent' => $notification->total_sent,
                'total_delivered' => $notification->total_delivered,
                'total_read' => $notification->total_read,
                'delivery_rate' => $notification->delivery_rate,
                'read_rate' => $notification->read_rate,
            ],
            'creator' => [
                'id' => $notification->createdBy?->id,
                'name' => $notification->createdBy?->full_name,
                'username' => $notification->createdBy?->username,
            ],
            'created_at' => $notification->created_at->toISOString(),
            'time_ago' => $notification->time_ago,
        ];

        return GetNotificationDetailsResDTO::fromArray($responseData);
    }
}
