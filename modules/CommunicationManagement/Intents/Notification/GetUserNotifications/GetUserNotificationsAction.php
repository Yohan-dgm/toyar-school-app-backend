<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetUserNotifications;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class GetUserNotificationsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getUserNotificationsUserDTO = GetUserNotificationsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];

        // System Data Validation
        $getUserNotificationsSystemDTO = GetUserNotificationsSystemDTO::validate($system_data);

        // Final Data Validation
        $getUserNotificationsDTO = GetUserNotificationsDTO::validate(array_merge($getUserNotificationsUserDTO, $getUserNotificationsSystemDTO));

        // Set pagination defaults
        $page = $getUserNotificationsDTO['page'] ?? 1;
        $perPage = $getUserNotificationsDTO['per_page'] ?? 20;
        $userId = $getUserNotificationsDTO['user_id'];

        // Build query for user's notifications
        $query = Notification::query()
            ->join('notification_recipients as nr', 'notifications.id', '=', 'nr.notification_id')
            ->leftJoin('notification_types as nt', 'notifications.notification_type_id', '=', 'nt.id')
            ->where('nr.user_id', $userId)
            ->where('notifications.is_active', true)
            ->notExpired()
            ->select([
                'notifications.*',
                'nr.is_read',
                'nr.read_at',
                'nr.is_delivered',
                'nr.delivered_at',
                'nt.name as type_name',
                'nt.slug as type_slug',
                'nt.icon as type_icon',
                'nt.color as type_color',
            ]);

        // Apply filters
        if ($getUserNotificationsDTO['filter']) {
            $this->applyFilter($query, $getUserNotificationsDTO['filter']);
        }

        if ($getUserNotificationsDTO['priority']) {
            $query->where('notifications.priority', $getUserNotificationsDTO['priority']);
        }

        if ($getUserNotificationsDTO['type_id']) {
            $query->where('notifications.notification_type_id', $getUserNotificationsDTO['type_id']);
        }

        if ($getUserNotificationsDTO['unread_only']) {
            $query->where('nr.is_read', false);
        }

        if ($getUserNotificationsDTO['search']) {
            $search = $getUserNotificationsDTO['search'];
            $query->where(function ($q) use ($search) {
                $q->where('notifications.title', 'ILIKE', "%{$search}%")
                    ->orWhere('notifications.message', 'ILIKE', "%{$search}%");
            });
        }

        // Get paginated results
        $results = $query->orderBy('notifications.created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Format notifications
        $notifications = $results->getCollection()->map(function ($item) {
            return GetUserNotificationsResDTO::formatNotification(
                $item->toArray(),
                [
                    'is_read' => $item->is_read,
                    'read_at' => $item->read_at,
                    'is_delivered' => $item->is_delivered,
                    'delivered_at' => $item->delivered_at,
                ]
            );
        })->toArray();

        // Get user notification stats
        $stats = $this->getUserNotificationStats($userId);

        // Prepare response
        $responseData = [
            'notifications' => $notifications,
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
                'has_next_page' => $results->hasMorePages(),
                'has_prev_page' => $results->currentPage() > 1,
            ],
            'stats' => $stats,
        ];

        return GetUserNotificationsResDTO::fromArray($responseData);
    }

    private function applyFilter($query, string $filter): void
    {
        switch ($filter) {
            case 'read':
                $query->where('nr.is_read', true);
                break;
            case 'unread':
                $query->where('nr.is_read', false);
                break;
            case 'delivered':
                $query->where('nr.is_delivered', true);
                break;
            case 'pending':
                $query->where('nr.is_delivered', false);
                break;
            case 'all':
            default:
                // No additional filter
                break;
        }
    }

    private function getUserNotificationStats(int $userId): array
    {
        $stats = NotificationRecipient::where('user_id', $userId)
            ->join('notifications', 'notification_recipients.notification_id', '=', 'notifications.id')
            ->where('notifications.is_active', true)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN notification_recipients.is_read = true THEN 1 ELSE 0 END) as read,
                SUM(CASE WHEN notification_recipients.is_read = false THEN 1 ELSE 0 END) as unread,
                SUM(CASE WHEN notification_recipients.is_delivered = true THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN notification_recipients.is_delivered = false THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN notifications.priority = \'urgent\' AND notification_recipients.is_read = false THEN 1 ELSE 0 END) as urgent_unread,
                SUM(CASE WHEN notifications.priority = \'high\' AND notification_recipients.is_read = false THEN 1 ELSE 0 END) as high_unread
            ')
            ->first();

        return [
            'total' => (int) $stats->total,
            'read' => (int) $stats->read,
            'unread' => (int) $stats->unread,
            'delivered' => (int) $stats->delivered,
            'pending' => (int) $stats->pending,
            'urgent_unread' => (int) $stats->urgent_unread,
            'high_unread' => (int) $stats->high_unread,
        ];
    }
}
