<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class GetNotificationStatsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getNotificationStatsUserDTO = GetNotificationStatsUserDTO::validate($payloadArray);

        // System Data Prep
        $system_data = [];
        $system_data['user_id'] = $actionData['user_id'];
        $system_data['requested_at'] = now()->toISOString();

        // System Data Validation
        $getNotificationStatsSystemDTO = GetNotificationStatsSystemDTO::validate($system_data);

        // Final Data Validation
        $getNotificationStatsDTO = GetNotificationStatsDTO::validate(array_merge($getNotificationStatsUserDTO, $getNotificationStatsSystemDTO));

        $userId = $getNotificationStatsDTO['user_id'];

        // Build base query for user's notifications
        $baseQuery = NotificationRecipient::query()
            ->join('notifications', 'notification_recipients.notification_id', '=', 'notifications.id')
            ->join('notification_types', 'notifications.notification_type_id', '=', 'notification_types.id')
            ->where('notification_recipients.user_id', $userId)
            ->whereNull('notifications.deleted_at');

        // Apply filters
        $this->applyFilters($baseQuery, $getNotificationStatsDTO);

        // Get total notifications count
        $totalNotifications = (clone $baseQuery)->count();

        // Get unread count
        $unreadCount = (clone $baseQuery)
            ->where('notification_recipients.read_at', null)
            ->count();

        // Get unread by priority
        $unreadByPriority = $this->getUnreadByPriority($baseQuery, $getNotificationStatsDTO);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($baseQuery, $getNotificationStatsDTO);

        // Get breakdown by notification type
        $byType = $this->getByType($baseQuery, $getNotificationStatsDTO);

        // Get priority breakdown
        $priorityBreakdown = $this->getPriorityBreakdown($baseQuery, $getNotificationStatsDTO);

        // Get last notification timestamp
        $lastNotificationAt = (clone $baseQuery)
            ->orderByDesc('notifications.created_at')
            ->value('notifications.created_at');

        return GetNotificationStatsResDTO::validate([
            'total_notifications' => $totalNotifications,
            'unread_count' => $unreadCount,
            'unread_by_priority' => $unreadByPriority,
            'recent_activity' => $recentActivity,
            'by_type' => $byType,
            'priority_breakdown' => $priorityBreakdown,
            'last_notification_at' => $lastNotificationAt ? $lastNotificationAt->toISOString() : null,
            'generated_at' => now()->toISOString(),
        ]);
    }

    private function applyFilters($query, $dto): void
    {
        // Apply date range filter
        if (isset($dto['date_range']) && $dto['date_range']) {
            switch ($dto['date_range']) {
                case 'today':
                    $query->whereDate('notifications.created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('notifications.created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek(),
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('notifications.created_at', Carbon::now()->month)
                        ->whereYear('notifications.created_at', Carbon::now()->year);
                    break;
                    // 'all' applies no filter
            }
        }

        // Apply priority filter
        if (isset($dto['priority_filter']) && $dto['priority_filter'] && ! empty($dto['priority_filter'])) {
            $query->whereIn('notifications.priority', $dto['priority_filter']);
        }

        // Apply type filter
        if (isset($dto['type_filter']) && $dto['type_filter'] && ! empty($dto['type_filter'])) {
            $query->whereIn('notifications.notification_type_id', $dto['type_filter']);
        }

        // Apply read status filter
        if (isset($dto['include_read']) && ! $dto['include_read']) {
            $query->whereNull('notification_recipients.read_at');
        }

        // Apply archived filter
        if (isset($dto['include_archived']) && ! $dto['include_archived']) {
            $query->whereNull('notification_recipients.archived_at');
        }
    }

    private function getUnreadByPriority($baseQuery, $dto): array
    {
        $unreadByPriority = (clone $baseQuery)
            ->select('notifications.priority', DB::raw('count(*) as count'))
            ->whereNull('notification_recipients.read_at')
            ->groupBy('notifications.priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Ensure all priorities are represented
        return [
            'normal' => $unreadByPriority['normal'] ?? 0,
            'high' => $unreadByPriority['high'] ?? 0,
            'urgent' => $unreadByPriority['urgent'] ?? 0,
        ];
    }

    private function getRecentActivity($baseQuery, $dto): array
    {
        $today = (clone $baseQuery)
            ->whereDate('notifications.created_at', Carbon::today())
            ->count();

        $thisWeek = (clone $baseQuery)
            ->whereBetween('notifications.created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->count();

        $thisMonth = (clone $baseQuery)
            ->whereMonth('notifications.created_at', Carbon::now()->month)
            ->whereYear('notifications.created_at', Carbon::now()->year)
            ->count();

        return [
            'today' => $today,
            'this_week' => $thisWeek,
            'this_month' => $thisMonth,
        ];
    }

    private function getByType($baseQuery, $dto): array
    {
        $byType = (clone $baseQuery)
            ->select(
                'notification_types.id',
                'notification_types.name',
                'notification_types.slug',
                'notification_types.color',
                'notification_types.icon',
                DB::raw('count(*) as total_count'),
                DB::raw('sum(case when notification_recipients.read_at is null then 1 else 0 end) as unread_count')
            )
            ->groupBy('notification_types.id', 'notification_types.name', 'notification_types.slug', 'notification_types.color', 'notification_types.icon')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'color' => $item->color,
                        'icon' => $item->icon,
                        'count' => $item->total_count,
                        'unread' => $item->unread_count,
                    ],
                ];
            })
            ->toArray();

        return $byType;
    }

    private function getPriorityBreakdown($baseQuery, $dto): array
    {
        $priorityBreakdown = (clone $baseQuery)
            ->select('notifications.priority', DB::raw('count(*) as count'))
            ->groupBy('notifications.priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Ensure all priorities are represented
        return [
            'normal' => $priorityBreakdown['normal'] ?? 0,
            'high' => $priorityBreakdown['high'] ?? 0,
            'urgent' => $priorityBreakdown['urgent'] ?? 0,
        ];
    }
}
