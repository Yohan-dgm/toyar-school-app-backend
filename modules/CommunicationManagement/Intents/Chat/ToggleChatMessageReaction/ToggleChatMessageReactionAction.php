<?php

namespace Modules\CommunicationManagement\Intents\Chat\ToggleChatMessageReaction;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessageReaction;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Validation\ValidationException;
use App\Events\MessageUpdatedToGroup;

class ToggleChatMessageReactionAction
{
    use AsAction;

    public function handle(array $payload, array $actionData): array
    {
        $messageId = $payload['message_id'];
        $emoji = $payload['emoji'];
        $userId = $actionData['user_id'];

        $message = ChatMessage::findOrFail($messageId);

        // Security: Must be a member of the group to react
        $isMember = ChatGroupMember::where('chat_group_id', $message->chat_group_id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();

        if (!$isMember) {
            throw ValidationException::withMessages([
                'message_id' => ['You must be a member of the group to react.'],
            ]);
        }

        $existing = ChatMessageReaction::where('chat_message_id', $messageId)
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            ChatMessageReaction::create([
                'chat_message_id' => $messageId,
                'user_id' => $userId,
                'emoji' => $emoji,
            ]);
            $status = 'added';
        }

        // Get updated reactions for broadcast
        $reactions = ChatMessageReaction::where('chat_message_id', $messageId)
            ->select('emoji', \DB::raw('count(*) as count'))
            ->groupBy('emoji')
            ->get();

        // Broadcast update to group using the standard DTO format
        $freshMessage = ChatMessage::with(['user', 'reactions'])->find($messageId);
        
        // We need to fetch the read_count if possible, although for a reaction update, 
        // the existing frontend state likely has the count. For consistency, let's format it.
        $formattedMessage = \Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesResDTO::formatMessage($freshMessage->toArray());

        \Illuminate\Support\Facades\Log::info('🔄 Broadcasting MessageUpdatedToGroup', [
            'group_id' => $message->chat_group_id,
            'message_id' => $messageId,
            'reactions_count' => count($formattedMessage['reactions'] ?? [])
        ]);
        
        broadcast(new MessageUpdatedToGroup((int)$message->chat_group_id, $formattedMessage));

        return [
            'success' => true,
            'status' => $status,
            'message' => $formattedMessage,
        ];
    }
}
