<?php

namespace Modules\CommunicationManagement\Intents\PushNotification\GetPushNotificationStats;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Services\ExpoPushNotificationService;
use App\Services\NotificationErrorHandler;

class GetPushNotificationStatsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $days = $payloadArray['days'] ?? 7;

        // Get push notification stats
        $pushService = app(ExpoPushNotificationService::class);
        $pushStats = $pushService->getPushStats($days);

        // Get error stats
        $errorStats = NotificationErrorHandler::getErrorStats($days);

        // Combine stats
        $stats = [
            'push_stats' => $pushStats,
            'error_stats' => $errorStats,
            'period_days' => $days,
            'generated_at' => now()->toISOString(),
        ];

        return [
            'success' => true,
            'data' => $stats
        ];
    }
}