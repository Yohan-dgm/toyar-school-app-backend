<?php

namespace Modules\CommunicationManagement\Intents\Chat\DeleteChatMessage;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatMessage;
use Illuminate\Validation\ValidationException;

class DeleteChatMessageAction
{
    use AsAction;

    public function handle(array $payload, array $actionData): bool
    {
        $messageId = $payload['message_id'];
        $userId = $actionData['user_id'];

        $message = ChatMessage::findOrFail($messageId);

        // Security: Only sender can delete their message
        if ($message->user_id !== $userId) {
            throw ValidationException::withMessages([
                'message_id' => ['You can only delete your own messages.'],
            ]);
        }

        $groupId = (int)$message->chat_group_id;
        $msgId = (int)$message->id;
        $deleted = $message->delete();

        if ($deleted) {
            // Real-time broadcast to group
            broadcast(new \App\Events\MessageDeletedFromGroup($groupId, $msgId));

            // Real-time broadcast to individual members (to remove from global stacks)
            $memberIds = \Modules\CommunicationManagement\Models\ChatGroupMember::where('chat_group_id', $groupId)
                ->where('is_active', true)
                ->pluck('user_id')
                ->toArray();

            foreach ($memberIds as $memberId) {
                broadcast(new \App\Events\MessageDeleted((int)$memberId, $msgId, $groupId));
            }
        }

        return $deleted;
    }
}
