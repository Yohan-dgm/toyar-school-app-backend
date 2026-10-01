<?php

namespace Modules\CommunicationManagement\Intents\Chat\UpdateChatMessage;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateChatMessageAction
{
    use AsAction;

    public function handle(array $payload, array $actionData): ChatMessage
    {
        $messageId = $payload['message_id'];
        $content = $payload['content'];
        $userId = $actionData['user_id'];

        $message = ChatMessage::with(['user', 'reactions'])->findOrFail($messageId);

        // Security: Only sender can edit their message
        if ($message->user_id !== $userId) {
            throw ValidationException::withMessages([
                'message_id' => ['You can only edit your own messages.'],
            ]);
        }

        // Only text messages can be edited (generally)
        if ($message->type !== 'text') {
             throw ValidationException::withMessages([
                'message_id' => ['Only text messages can be edited.'],
            ]);
        }

        $message->update([
            'content' => $content,
        ]);

        // Real-time broadcast to group using consistent DTO formatting
        $formattedMessage = \Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesResDTO::formatMessage($message->toArray());
        broadcast(new \App\Events\MessageUpdatedToGroup((int)$message->chat_group_id, $formattedMessage));

        return $message;
    }
}
