<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Models\UserPushToken;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class NotificationErrorHandler
{
    /**
     * Handle push notification delivery errors
     */
    public static function handlePushDeliveryError(
        UserPushToken $token,
        string $error,
        ?NotificationRecipient $recipient = null
    ): void {
        Log::error('Push notification delivery failed', [
            'token_id' => $token->id,
            'user_id' => $token->user_id,
            'device_id' => $token->device_id,
            'platform' => $token->platform,
            'error' => $error,
            'recipient_id' => $recipient?->id,
            'failed_deliveries' => $token->failed_deliveries,
        ]);

        // Increment failure count
        $token->incrementFailure($error);

        // Handle specific error types
        self::handleSpecificErrors($token, $error);

        // Check if token should be deactivated
        self::checkTokenDeactivation($token);

        // Update recipient status if provided
        if ($recipient) {
            $recipient->update([
                'push_sent' => false,
                'push_sent_at' => null,
                'failure_reason' => $error,
            ]);
        }
    }

    /**
     * Handle specific error types with appropriate actions
     */
    private static function handleSpecificErrors(UserPushToken $token, string $error): void
    {
        $error = strtolower($error);

        // Invalid token errors - deactivate immediately
        if (self::isInvalidTokenError($error)) {
            $token->deactivate("Invalid token: {$error}");
            Log::warning('Push token deactivated due to invalid token error', [
                'token_id' => $token->id,
                'error' => $error,
            ]);
            return;
        }

        // Rate limiting errors - temporarily back off
        if (self::isRateLimitError($error)) {
            self::handleRateLimitError($token, $error);
            return;
        }

        // Server errors - might be temporary
        if (self::isServerError($error)) {
            self::handleServerError($token, $error);
            return;
        }

        // Device not registered errors
        if (self::isDeviceNotRegisteredError($error)) {
            $token->deactivate("Device not registered: {$error}");
            Log::info('Push token deactivated - device not registered', [
                'token_id' => $token->id,
                'error' => $error,
            ]);
            return;
        }
    }

    /**
     * Check if error indicates an invalid token
     */
    private static function isInvalidTokenError(string $error): bool
    {
        $invalidTokenIndicators = [
            'invalidcredentials',
            'mismatssenderid',
            'invalidpackagename',
            'messagetoobig',
            'invalidregistration',
            'expiredtoken',
        ];

        foreach ($invalidTokenIndicators as $indicator) {
            if (strpos($error, $indicator) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if error indicates rate limiting
     */
    private static function isRateLimitError(string $error): bool
    {
        $rateLimitIndicators = [
            'messagerateexceeded',
            'toomanyrequests',
            'ratelimited',
            '429',
        ];

        foreach ($rateLimitIndicators as $indicator) {
            if (strpos($error, $indicator) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if error indicates server error
     */
    private static function isServerError(string $error): bool
    {
        $serverErrorIndicators = [
            'internalservererror',
            'serviceunavailable',
            '500',
            '502',
            '503',
            '504',
            'timeout',
            'networkerror',
        ];

        foreach ($serverErrorIndicators as $indicator) {
            if (strpos($error, $indicator) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if error indicates device not registered
     */
    private static function isDeviceNotRegisteredError(string $error): bool
    {
        $deviceNotRegisteredIndicators = [
            'devicenotregistered',
            'notregistered',
            'registration_not_found',
        ];

        foreach ($deviceNotRegisteredIndicators as $indicator) {
            if (strpos($error, $indicator) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle rate limit errors
     */
    private static function handleRateLimitError(UserPushToken $token, string $error): void
    {
        Log::warning('Push notification rate limited', [
            'token_id' => $token->id,
            'user_id' => $token->user_id,
            'error' => $error,
        ]);

        // Don't deactivate for rate limiting, but increment failures
        // The retry mechanism will handle backoff
    }

    /**
     * Handle server errors
     */
    private static function handleServerError(UserPushToken $token, string $error): void
    {
        Log::warning('Push notification server error', [
            'token_id' => $token->id,
            'user_id' => $token->user_id,
            'error' => $error,
        ]);

        // Don't deactivate for server errors, they might be temporary
        // But log them for monitoring
    }

    /**
     * Check if token should be deactivated based on failure count
     */
    private static function checkTokenDeactivation(UserPushToken $token): void
    {
        if ($token->failed_deliveries >= UserPushToken::MAX_FAILED_DELIVERIES) {
            $token->deactivate('Exceeded maximum failed deliveries');
            
            Log::warning('Push token deactivated due to excessive failures', [
                'token_id' => $token->id,
                'user_id' => $token->user_id,
                'failed_deliveries' => $token->failed_deliveries,
            ]);

            // Optionally notify user about token issues
            self::notifyUserAboutTokenIssue($token);
        }
    }

    /**
     * Notify user about push token issues
     */
    private static function notifyUserAboutTokenIssue(UserPushToken $token): void
    {
        try {
            // Create an in-app notification about push notification issues
            $notificationService = app(\Modules\CommunicationManagement\Services\NotificationService::class);
            
            $notificationService->sendSystemNotification(
                'Push Notification Issue',
                'We\'re having trouble sending push notifications to one of your devices. Please update the app or re-login to fix this issue.',
                [$token->user_id],
                'normal'
            );

        } catch (\Exception $e) {
            Log::error('Failed to notify user about token issue', [
                'token_id' => $token->id,
                'user_id' => $token->user_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle successful push notification delivery
     */
    public static function handlePushDeliverySuccess(
        UserPushToken $token,
        ?NotificationRecipient $recipient = null
    ): void {
        // Reset failure count on successful delivery
        if ($token->failed_deliveries > 0) {
            $token->resetFailures();
            
            Log::info('Push token failures reset after successful delivery', [
                'token_id' => $token->id,
                'user_id' => $token->user_id,
            ]);
        }

        // Update last used timestamp
        $token->markAsUsed();

        // Update recipient status if provided
        if ($recipient) {
            $recipient->markPushSent($token->push_token);
        }
    }

    /**
     * Handle broadcast connection errors
     */
    public static function handleBroadcastError(string $channel, string $event, \Exception $error): void
    {
        Log::error('Broadcasting failed', [
            'channel' => $channel,
            'event' => $event,
            'error' => $error->getMessage(),
            'trace' => $error->getTraceAsString(),
        ]);

        // Optionally implement fallback mechanisms here
        // For example, queue the broadcast for retry
    }

    /**
     * Get error statistics for monitoring
     */
    public static function getErrorStats(int $days = 7): array
    {
        $startDate = now()->subDays($days);

        // Push token error stats
        $tokenStats = UserPushToken::where('updated_at', '>=', $startDate)
            ->whereNotNull('failure_reason')
            ->selectRaw('
                COUNT(*) as total_errors,
                SUM(CASE WHEN is_active = false THEN 1 ELSE 0 END) as deactivated_tokens,
                COUNT(DISTINCT user_id) as affected_users
            ')
            ->first();

        // Get most common error reasons
        $commonErrors = UserPushToken::where('updated_at', '>=', $startDate)
            ->whereNotNull('failure_reason')
            ->groupBy('failure_reason')
            ->selectRaw('failure_reason, COUNT(*) as count')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->pluck('count', 'failure_reason')
            ->toArray();

        // Platform breakdown
        $platformErrors = UserPushToken::where('updated_at', '>=', $startDate)
            ->whereNotNull('failure_reason')
            ->groupBy('platform')
            ->selectRaw('platform, COUNT(*) as count')
            ->get()
            ->pluck('count', 'platform')
            ->toArray();

        return [
            'period_days' => $days,
            'total_errors' => (int) $tokenStats->total_errors,
            'deactivated_tokens' => (int) $tokenStats->deactivated_tokens,
            'affected_users' => (int) $tokenStats->affected_users,
            'common_errors' => $commonErrors,
            'platform_errors' => $platformErrors,
            'error_rate' => $tokenStats->total_errors > 0 ? 
                round(($tokenStats->deactivated_tokens / $tokenStats->total_errors) * 100, 2) : 0,
        ];
    }

    /**
     * Generate error report
     */
    public static function generateErrorReport(): string
    {
        $stats = self::getErrorStats();
        $pushStats = app(\Modules\CommunicationManagement\Services\ExpoPushNotificationService::class)->getPushStats();

        $report = "# Push Notification Error Report\n\n";
        $report .= "## Overview (Last 7 days)\n";
        $report .= "- Total Errors: {$stats['total_errors']}\n";
        $report .= "- Deactivated Tokens: {$stats['deactivated_tokens']}\n";
        $report .= "- Affected Users: {$stats['affected_users']}\n";
        $report .= "- Error Rate: {$stats['error_rate']}%\n\n";

        $report .= "## Current Token Health\n";
        $report .= "- Active Tokens: {$pushStats['active_tokens']}\n";
        $report .= "- Tokens with Failures: {$pushStats['tokens_with_failures']}\n";
        $report .= "- Health Percentage: {$pushStats['health_percentage']}%\n\n";

        if (!empty($stats['common_errors'])) {
            $report .= "## Most Common Errors\n";
            foreach ($stats['common_errors'] as $error => $count) {
                $report .= "- {$error}: {$count}\n";
            }
            $report .= "\n";
        }

        if (!empty($stats['platform_errors'])) {
            $report .= "## Platform Breakdown\n";
            foreach ($stats['platform_errors'] as $platform => $count) {
                $report .= "- {$platform}: {$count}\n";
            }
        }

        return $report;
    }
}