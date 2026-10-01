<?php

namespace Modules\CommunicationManagement\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Models\UserPushToken;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;
use App\Services\NotificationErrorHandler;

class ExpoPushNotificationService
{
    private const EXPO_PUSH_URL = 'https://exp.host/--/api/v2/push/send';
    private const EXPO_RECEIPT_URL = 'https://exp.host/--/api/v2/push/getReceipts';
    private const MAX_BATCH_SIZE = 100;
    private const MAX_RETRIES = 3;
    private const RETRY_DELAY = 1; // seconds

    /**
     * Send push notifications for a notification
     */
    public function sendNotificationPushes(Notification $notification): array
    {
        $recipients = $notification->recipients()->with('user')->get();
        $results = [];

        // Get valid push tokens for recipients
        $userIds = $recipients->pluck('user_id')->unique()->toArray();
        $pushTokens = UserPushToken::getValidTokensForUsers($userIds);

        if ($pushTokens->isEmpty()) {
            Log::info('No valid push tokens found for notification', [
                'notification_id' => $notification->id,
                'user_ids' => $userIds,
            ]);
            return [];
        }

        // Group tokens by user for tracking
        $tokensByUser = $pushTokens->groupBy('user_id');

        foreach ($recipients as $recipient) {
            $userTokens = $tokensByUser->get($recipient->user_id, collect());
            
            if ($userTokens->isEmpty()) {
                continue;
            }

            foreach ($userTokens as $pushToken) {
                $result = $this->sendSinglePushNotification($notification, $recipient, $pushToken);
                $results[] = $result;
            }
        }

        return $results;
    }

    /**
     * Send a single push notification
     */
    private function sendSinglePushNotification(Notification $notification, NotificationRecipient $recipient, UserPushToken $pushToken): array
    {
        $payload = $this->buildPushPayload($notification, $pushToken);
        
        $response = $this->sendPushWithRetry($payload);
        
        // Update recipient record and handle errors
        if ($response['success']) {
            NotificationErrorHandler::handlePushDeliverySuccess($pushToken, $recipient);
        } else {
            NotificationErrorHandler::handlePushDeliveryError(
                $pushToken,
                $response['error'] ?? 'Unknown error',
                $recipient
            );
        }

        return array_merge($response, [
            'notification_id' => $notification->id,
            'recipient_id' => $recipient->id,
            'token_id' => $pushToken->id,
        ]);
    }

    /**
     * Build push notification payload
     */
    private function buildPushPayload(Notification $notification, UserPushToken $pushToken): array
    {
        $payload = [
            'to' => $pushToken->push_token,
            'title' => $notification->title,
            'body' => $notification->message,
            'sound' => 'default',
        ];

        // Add data payload
        $data = [
            'notificationId' => $notification->id,
            'type' => $notification->notificationType?->slug ?? 'general',
            'priority' => $notification->priority,
        ];

        if ($notification->action_url) {
            $data['actionUrl'] = $notification->action_url;
        }

        if ($notification->image_url) {
            $data['imageUrl'] = $notification->image_url;
        }

        $payload['data'] = $data;

        // Set priority and display behavior
        switch ($notification->priority) {
            case 'urgent':
                $payload['priority'] = 'high';
                $payload['badge'] = 1;
                $payload['expiration'] = time() + 3600; // 1 hour
                break;
            case 'high':
                $payload['priority'] = 'high';
                break;
            case 'normal':
            default:
                $payload['priority'] = 'default';
                break;
        }

        // Platform specific settings
        if ($pushToken->platform === UserPushToken::PLATFORM_IOS) {
            $payload['ios'] = [
                'sound' => 'default',
                'badge' => 1,
            ];
        } elseif ($pushToken->platform === UserPushToken::PLATFORM_ANDROID) {
            $payload['android'] = [
                'sound' => 'default',
                'priority' => $notification->priority === 'urgent' ? 'high' : 'normal',
                'channelId' => 'school-notifications',
            ];
        }

        return $payload;
    }

    /**
     * Send push notification with retry logic
     */
    private function sendPushWithRetry(array $payload, int $attempt = 1): array
    {
        try {
            Log::channel('single')->info('DEBUG: Expo Payload', $payload);

            $response = Http::timeout(30)
                ->retry(self::MAX_RETRIES, self::RETRY_DELAY * 1000, function ($exception) {
                    return $exception instanceof \Illuminate\Http\Client\ConnectionException;
                })
                ->post(self::EXPO_PUSH_URL, $payload);

            Log::channel('single')->info('DEBUG: Expo Response: ' . $response->body());

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data']) && is_array($responseData['data']) && count($responseData['data']) > 0) {
                    $ticketData = $responseData['data'][0];
                    
                    if (isset($ticketData['status']) && $ticketData['status'] === 'ok') {
                        return [
                            'success' => true,
                            'ticket_id' => $ticketData['id'] ?? null,
                            'attempt' => $attempt,
                        ];
                    } else {
                        return [
                            'success' => false,
                            'error' => $ticketData['message'] ?? 'Unknown error',
                            'details' => $ticketData['details'] ?? null,
                            'attempt' => $attempt,
                        ];
                    }
                }
            }

            return [
                'success' => false,
                'error' => 'Invalid response from Expo',
                'status_code' => $response->status(),
                'attempt' => $attempt,
            ];

        } catch (\Exception $e) {
            Log::error('Expo push notification failed', [
                'error' => $e->getMessage(),
                'attempt' => $attempt,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'attempt' => $attempt,
            ];
        }
    }

    /**
     * Send push notifications in batches
     */
    public function sendBatchPushNotifications(array $payloads): array
    {
        if (empty($payloads)) {
            return [];
        }

        $chunks = array_chunk($payloads, self::MAX_BATCH_SIZE);
        $allResults = [];

        foreach ($chunks as $chunk) {
            $result = $this->sendBatchChunk($chunk);
            $allResults = array_merge($allResults, $result);
        }

        return $allResults;
    }

    /**
     * Send a batch chunk of push notifications
     */
    private function sendBatchChunk(array $payloads): array
    {
        try {
            $response = Http::timeout(30)
                ->retry(self::MAX_RETRIES, self::RETRY_DELAY * 1000)
                ->post(self::EXPO_PUSH_URL, $payloads);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    return array_map(function ($ticket, $index) use ($payloads) {
                        return [
                            'success' => $ticket['status'] === 'ok',
                            'ticket_id' => $ticket['id'] ?? null,
                            'error' => $ticket['status'] !== 'ok' ? ($ticket['message'] ?? 'Unknown error') : null,
                            'token' => $payloads[$index]['to'] ?? null,
                            'payload_index' => $index,
                        ];
                    }, $responseData['data'], array_keys($responseData['data']));
                }
            }

            // If we get here, the response was not successful
            return array_map(function ($payload, $index) use ($response) {
                return [
                    'success' => false,
                    'error' => 'Batch request failed',
                    'status_code' => $response->status(),
                    'token' => $payload['to'] ?? null,
                    'payload_index' => $index,
                ];
            }, $payloads, array_keys($payloads));

        } catch (\Exception $e) {
            Log::error('Expo batch push notification failed', [
                'error' => $e->getMessage(),
                'payload_count' => count($payloads),
            ]);

            return array_map(function ($payload, $index) use ($e) {
                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'token' => $payload['to'] ?? null,
                    'payload_index' => $index,
                ];
            }, $payloads, array_keys($payloads));
        }
    }

    /**
     * Get receipts for push notification tickets
     */
    public function getReceiptsForTickets(array $ticketIds): array
    {
        if (empty($ticketIds)) {
            return [];
        }

        try {
            $response = Http::timeout(30)
                ->post(self::EXPO_RECEIPT_URL, [
                    'ids' => $ticketIds,
                ]);

            if ($response->successful()) {
                $responseData = $response->json();
                return $responseData['data'] ?? [];
            }

            Log::warning('Failed to get Expo receipts', [
                'status_code' => $response->status(),
                'ticket_count' => count($ticketIds),
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Failed to get Expo receipts', [
                'error' => $e->getMessage(),
                'ticket_count' => count($ticketIds),
            ]);

            return [];
        }
    }

    /**
     * Check if a token is invalid based on error message
     */
    private function isTokenInvalid(string $error): bool
    {
        $invalidTokenMessages = [
            'DeviceNotRegistered',
            'InvalidCredentials', 
            'MessageTooBig',
            'MessageRateExceeded',
            'MismatchSenderId',
            'InvalidPackageName',
        ];

        foreach ($invalidTokenMessages as $message) {
            if (stripos($error, $message) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate Expo push token format
     */
    public function isValidExpoPushToken(string $token): bool
    {
        // Expo push tokens should start with ExponentPushToken[ or ExpoToken[
        return preg_match('/^Expo(nent)?PushToken\[.+\]$/', $token) === 1;
    }

    /**
     * Get push notification statistics
     */
    public function getPushStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $totalTokens = UserPushToken::count();
        $activeTokens = UserPushToken::active()->count();
        $recentlyUsed = UserPushToken::active()->recentlyUsed($days)->count();
        $withFailures = UserPushToken::active()->withFailures()->count();
        $exceedingThreshold = UserPushToken::exceedingFailureThreshold()->count();

        $platformStats = UserPushToken::active()
            ->selectRaw('platform, COUNT(*) as count')
            ->groupBy('platform')
            ->pluck('count', 'platform')
            ->toArray();

        return [
            'total_tokens' => $totalTokens,
            'active_tokens' => $activeTokens,
            'inactive_tokens' => $totalTokens - $activeTokens,
            'recently_used' => $recentlyUsed,
            'tokens_with_failures' => $withFailures,
            'tokens_exceeding_threshold' => $exceedingThreshold,
            'platform_distribution' => [
                'ios' => $platformStats[UserPushToken::PLATFORM_IOS] ?? 0,
                'android' => $platformStats[UserPushToken::PLATFORM_ANDROID] ?? 0,
            ],
            'health_percentage' => $totalTokens > 0 ? 
                round((($activeTokens - $withFailures) / $totalTokens) * 100, 2) : 100,
        ];
    }

    /**
     * Clean up invalid and old push tokens
     */
    public function cleanupTokens(): array
    {
        $cleaned = UserPushToken::cleanupInvalidTokens();
        
        return [
            'cleaned_tokens' => $cleaned,
            'timestamp' => now()->toISOString(),
        ];
    }
}