<?php

namespace Modules\CommunicationManagement\Intents\Chat\SetChatFocus;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class SetChatFocusAction
{
    use AsAction;

    public function handle(array $payload, array $actionData): array
    {
        $userId = $actionData['user_id'];
        $chatGroupId = $payload['chat_group_id'];

        $user = User::findOrFail($userId);
        
        // Update currently focused chat ID in database
        $user->update([
            'currently_focused_chat_id' => $chatGroupId
        ]);

        // Sync with Cache for Push Notification Service suppression
        $cacheKey = "user_chat_focus_{$userId}";
        if ($chatGroupId) {
            // Set focus with a short TTL (1 minute) to survive heartbeats
            \Illuminate\Support\Facades\Cache::put($cacheKey, (int)$chatGroupId, 60);
        } else {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        return [
            'success' => true,
            'message' => 'Chat focus updated successfully',
            'currently_focused_chat_id' => $chatGroupId
        ];
    }
}
