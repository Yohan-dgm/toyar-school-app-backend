<?php

namespace Modules\CommunicationManagement\Intents\Notification\MarkAsRead;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class MarkAsReadAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $markAsReadUserDTO = MarkAsReadUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $markAsReadSystemDTO = MarkAsReadSystemDTO::validate($system_data);

        // Final Data Validation
        $markAsReadDTO = MarkAsReadDTO::validate(array_merge($markAsReadUserDTO, $markAsReadSystemDTO));

        $userId = $markAsReadDTO['user_id'];
        $notificationId = $markAsReadDTO['notification_id'];
        $markAll = $markAsReadDTO['mark_all'] ?? false;

        // Check if notification exists and user has access to it
        $notification = Notification::find($notificationId);
        if (! $notification) {
            throw new \Exception('Notification not found');
        }

        // Check if user has this notification
        $userNotification = NotificationRecipient::where('notification_id', $notificationId)
            ->where('user_id', $userId)
            ->first();

        if (! $userNotification) {
            throw new \Exception('You do not have access to this notification');
        }

        $affectedCount = 0;

        if ($markAll) {
            // Mark all unread notifications for this user as read
            $affectedCount = NotificationRecipient::where('user_id', $userId)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            $message = $affectedCount > 0
                ? "Marked {$affectedCount} notifications as read"
                : 'No unread notifications found';
        } else {
            // Mark single notification as read
            if (! $userNotification->is_read) {
                $userNotification->update([
                    'is_read' => true,
                    'read_at' => Carbon::now(),
                ]);
                $affectedCount = 1;
                $message = 'Notification marked as read';
            } else {
                $message = 'Notification was already read';
            }
        }

        // Update notification statistics if we marked any notifications as read
        if ($affectedCount > 0) {
            if ($markAll) {
                // Update stats for all notifications that might have been affected
                $notificationIds = NotificationRecipient::where('user_id', $userId)
                    ->where('is_read', true)
                    ->where('read_at', '>=', Carbon::now()->subMinute())
                    ->pluck('notification_id')
                    ->unique();

                foreach ($notificationIds as $id) {
                    $notificationToUpdate = Notification::find($id);
                    if ($notificationToUpdate) {
                        $notificationToUpdate->updateStats();
                    }
                }
            } else {
                // Update stats for the single notification
                $notification->updateStats();
            }
        }

        // Prepare response data
        $responseData = [
            'affected_count' => $affectedCount,
            'success' => true,
            'message' => $message,
        ];

        return MarkAsReadResDTO::fromArray($responseData);
    }
}
