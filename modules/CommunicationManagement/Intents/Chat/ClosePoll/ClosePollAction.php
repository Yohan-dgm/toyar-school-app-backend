<?php

namespace Modules\CommunicationManagement\Intents\Chat\ClosePoll;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesResDTO;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessagePoll;

class ClosePollAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_message_id' => 'required|integer|exists:chat_messages,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $message = ChatMessage::findOrFail($payloadArray['chat_message_id']);

        if ($message->type !== 'poll') {
            throw ValidationException::withMessages([
                'chat_message_id' => ['This message is not a poll.'],
            ]);
        }

        $group = ChatGroup::active()->findOrFail($message->chat_group_id);

        // Only the poll's creator or a group admin may close it.
        if ($message->user_id !== $userId && !$group->isAdmin($userId)) {
            throw ValidationException::withMessages([
                'chat_message_id' => ['Only the poll creator or a group admin can end this poll.'],
            ]);
        }

        $poll = ChatMessagePoll::where('chat_message_id', $message->id)->firstOrFail();

        if (!$poll->is_closed) {
            $poll->update([
                'is_closed' => true,
                'closed_at' => now(),
                'closed_by' => $userId,
            ]);
        }

        $formattedMessage = GetChatMessagesResDTO::formatMessage($message->toArray());

        // Same rule as VotePollAction: broadcasts never carry a specific
        // user's own vote state.
        $broadcastMessage = $formattedMessage;
        $broadcastMessage['poll'] = $poll->toSummaryArray(null);
        broadcast(new \App\Events\MessageUpdatedToGroup((int) $message->chat_group_id, $broadcastMessage));

        return [
            'poll' => $poll->toSummaryArray($userId),
        ];
    }
}
