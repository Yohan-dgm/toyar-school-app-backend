<?php

namespace Modules\CommunicationManagement\Services;

use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Models\UserPushToken;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Support\Facades\Http;

class ChatPushNotificationService
{
    private const EXPO_PUSH_URL = 'https://exp.host/--/api/v2/push/send';

    /**
     * Send push notifications for a chat message to all other group members
     */
    public function sendChatPushes(ChatGroup $group, ChatMessage $message, int $senderId): array
    {
        try {
            // Get all other active members of the group
            $memberIds = ChatGroupMember::where('chat_group_id', $group->id)
                ->where('user_id', '!=', $senderId)
                ->where('is_active', true)
                ->pluck('user_id')
                ->toArray();

            if (empty($memberIds)) {
                return [];
            }

            // Filter out users who are currently "focused" on this chat group
            $finalMemberIds = [];
            foreach ($memberIds as $id) {
                $focusedGroupId = \Illuminate\Support\Facades\Cache::get("user_chat_focus_{$id}");
                if ($focusedGroupId !== (int)$group->id) {
                    $finalMemberIds[] = $id;
                } else {
                    Log::info("Skipping push for user {$id} - currently focused on group {$group->id}");
                }
            }

            if (empty($finalMemberIds)) {
                return [];
            }

            // Get valid push tokens for these members
            $pushTokens = UserPushToken::getValidTokensForUsers($finalMemberIds);

            if ($pushTokens->isEmpty()) {
                return [];
            }

            // Fetch sender info once
            $sender = \Modules\UserManagement\Models\User::find($senderId);
            $senderName = $sender ? $sender->full_name : 'Someone';

            $payloads = [];
            foreach ($pushTokens as $token) {
                $payloads[] = $this->buildChatPushPayload($group, $message, $token, $senderName);
            }

            // Send in batches to Expo
            return $this->sendBatchPushNotifications($payloads);

        } catch (\Exception $e) {
            Log::error('Chat push notification service failed', [
                'chat_group_id' => $group->id,
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Build the push notification payload for a chat message
     */
    private function buildChatPushPayload(ChatGroup $group, ChatMessage $message, UserPushToken $pushToken, string $senderName): array
    {
        $groupName = $group->name ?? 'Chat Group';
        
        $body = $message->type === 'text' 
            ? $message->content 
            : "Sent an attachment";

        $payload = [
            'to' => $pushToken->push_token,
            'title' => $groupName,
            'body' => "{$senderName}: {$body}",
            'sound' => 'default',
            'data' => [
                'type' => 'chat_message',
                'chatGroupId' => $group->id,
                'messageId' => $message->id,
                'senderId' => $message->user_id,
            ]
        ];

        // Platform specific settings
        if ($pushToken->platform === UserPushToken::PLATFORM_IOS) {
            $payload['ios'] = [
                'sound' => 'default',
                'badge' => 1,
            ];
        } elseif ($pushToken->platform === UserPushToken::PLATFORM_ANDROID) {
            $payload['android'] = [
                'sound' => 'default',
                'priority' => 'high',
                'channelId' => 'chat-notifications',
            ];
        }

        return $payload;
    }

    /**
     * Send push notifications in batches to Expo
     */
    private function sendBatchPushNotifications(array $payloads): array
    {
        if (empty($payloads)) {
            return [];
        }

        $results = [];
        $chunks = array_chunk($payloads, 100); // Expo supports up to 100 at once

        foreach ($chunks as $chunk) {
            try {
                $response = Http::timeout(30)->post(self::EXPO_PUSH_URL, $chunk);
                
                if ($response->successful()) {
                    $results[] = [
                        'success' => true,
                        'data' => $response->json()
                    ];
                } else {
                    Log::error('Expo batch push failed', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    $results[] = [
                        'success' => false,
                        'status' => $response->status()
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Expo batch push exception', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }
}
