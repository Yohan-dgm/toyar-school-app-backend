<?php

namespace Modules\CommunicationManagement\Intents\Notification\DeleteNotification;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class DeleteNotificationAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteNotificationUserDTO = DeleteNotificationUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $deleteNotificationSystemDTO = DeleteNotificationSystemDTO::validate($system_data);

        // Final Data Validation
        $deleteNotificationDTO = DeleteNotificationDTO::validate(array_merge($deleteNotificationUserDTO, $deleteNotificationSystemDTO));

        $userId = $deleteNotificationDTO['user_id'];
        $notificationId = $deleteNotificationDTO['notification_id'];

        // Check if notification exists
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

        // For users, we just remove their recipient record (soft delete for user)
        // Only admins/creators should be able to actually delete the notification entirely
        $userNotification->delete();

        // Update notification statistics
        $notification->updateStats();

        // Prepare response data
        $responseData = [
            'success' => true,
            'message' => 'Notification deleted successfully',
            'notification_id' => $notificationId,
        ];

        return DeleteNotificationResDTO::fromArray($responseData);
    }
}
