<?php

namespace Modules\CommunicationManagement\Intents\Chat\VotePoll;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesResDTO;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessagePoll;
use Modules\CommunicationManagement\Models\ChatPollVote;

// Casting a vote REPLACES the caller's entire vote set for this poll in one
// transaction (delete-then-insert) — works identically whether the poll is
// single- or multi-choice, no separate add/remove-vote endpoints needed.
class VotePollAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_message_id' => 'required|integer|exists:chat_messages,id',
            'option_ids' => 'required|array|min:1',
            'option_ids.*' => 'required|integer',
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

        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'chat_message_id' => ['You are not a member of this chat group.'],
            ]);
        }

        if ($group->is_disabled) {
            throw ValidationException::withMessages([
                'chat_message_id' => ['This chat group has been disabled by an administrator.'],
            ]);
        }

        $poll = ChatMessagePoll::where('chat_message_id', $message->id)->firstOrFail();

        if ($poll->is_closed) {
            throw ValidationException::withMessages([
                'chat_message_id' => ['This poll is closed and no longer accepting votes.'],
            ]);
        }

        $optionIds = array_values(array_unique(array_map('intval', $payloadArray['option_ids'])));

        if (!$poll->allows_multiple_answers && count($optionIds) > 1) {
            throw ValidationException::withMessages([
                'option_ids' => ['This poll only allows a single choice.'],
            ]);
        }

        $validOptionIds = $poll->options()->pluck('id')->toArray();
        if (count(array_diff($optionIds, $validOptionIds)) > 0) {
            throw ValidationException::withMessages([
                'option_ids' => ['One or more selected options do not belong to this poll.'],
            ]);
        }

        DB::transaction(function () use ($poll, $userId, $validOptionIds, $optionIds) {
            // Replace this user's entire vote set for the poll.
            ChatPollVote::where('user_id', $userId)
                ->whereIn('chat_poll_option_id', $validOptionIds)
                ->delete();

            foreach ($optionIds as $optionId) {
                ChatPollVote::create([
                    'chat_poll_option_id' => $optionId,
                    'user_id' => $userId,
                    'created_at' => now(),
                ]);
            }
        });

        $poll->refresh();
        $formattedMessage = GetChatMessagesResDTO::formatMessage($message->toArray());

        // Broadcast carries no one user's own vote state — every member
        // receives this same payload. The voter's own updated selection is
        // returned directly to them below instead.
        $broadcastMessage = $formattedMessage;
        $broadcastMessage['poll'] = $poll->toSummaryArray(null);
        broadcast(new \App\Events\MessageUpdatedToGroup((int) $message->chat_group_id, $broadcastMessage));

        return [
            'poll' => $poll->toSummaryArray($userId),
        ];
    }
}
