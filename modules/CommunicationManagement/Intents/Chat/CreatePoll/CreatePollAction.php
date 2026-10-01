<?php

namespace Modules\CommunicationManagement\Intents\Chat\CreatePoll;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesResDTO;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessagePoll;
use Modules\CommunicationManagement\Models\ChatPollOption;

// Additive, dedicated poll-creation endpoint — new chat_messages row
// (type: 'poll') + a chat_message_polls row + its options, all in one
// transaction. Reuses the existing MessageSentToGroup/MessageSent broadcast
// events exactly like SendChatMessageAction, so a poll appears live in the
// thread exactly like any other new message.
class CreatePollAction
{
    use AsAction;

    private const MIN_OPTIONS = 2;
    private const MAX_OPTIONS = 12;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'question' => 'required|string|max:500',
            'options' => 'required|array|min:'.self::MIN_OPTIONS.'|max:'.self::MAX_OPTIONS,
            'options.*' => 'required|string|max:200',
            'allows_multiple_answers' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $chatGroupId = $payloadArray['chat_group_id'];

        $group = ChatGroup::active()->findOrFail($chatGroupId);

        if (!$group->isAdmin($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only group admins can create a poll.'],
            ]);
        }

        if ($group->is_disabled) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['This chat group has been disabled by an administrator.'],
            ]);
        }

        $options = array_values(array_filter(array_map('trim', $payloadArray['options'])));
        if (count($options) < self::MIN_OPTIONS) {
            throw ValidationException::withMessages([
                'options' => ['A poll needs at least '.self::MIN_OPTIONS.' options.'],
            ]);
        }

        return DB::transaction(function () use ($payloadArray, $userId, $chatGroupId, $options) {
            $message = ChatMessage::create([
                'chat_group_id' => $chatGroupId,
                'user_id' => $userId,
                'type' => 'poll',
                'content' => $payloadArray['question'],
            ]);

            $poll = ChatMessagePoll::create([
                'chat_message_id' => $message->id,
                'allows_multiple_answers' => (bool) ($payloadArray['allows_multiple_answers'] ?? false),
            ]);

            foreach ($options as $index => $optionText) {
                ChatPollOption::create([
                    'chat_message_poll_id' => $poll->id,
                    'option_text' => $optionText,
                    'position' => $index,
                ]);
            }

            ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('user_id', $userId)
                ->update(['last_read_at' => now()]);

            $sender = DB::table('user')->where('id', $userId)->first();
            $member = ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('user_id', $userId)
                ->first();

            $formattedMessage = GetChatMessagesResDTO::formatMessage(array_merge($message->toArray(), [
                'sender_name' => $sender->full_name ?? 'Someone',
                'sender_role' => $member->role ?? 'member',
            ]));

            // Broadcasts reach every member with the SAME payload, so the
            // poll data in them must never carry any one user's own vote
            // state — only the creator's direct HTTP response (below) does.
            $broadcastMessage = $formattedMessage;
            $broadcastMessage['poll'] = $poll->toSummaryArray(null);

            broadcast(new \App\Events\MessageSentToGroup((int) $chatGroupId, (int) $userId, $broadcastMessage));

            $memberIds = ChatGroupMember::where('chat_group_id', $chatGroupId)
                ->where('is_active', true)
                ->where('user_id', '!=', $userId)
                ->pluck('user_id')
                ->toArray();

            foreach ($memberIds as $memberId) {
                broadcast(new \App\Events\MessageSent((int) $memberId, (int) $userId, $broadcastMessage));
            }

            $formattedMessage['poll'] = $poll->toSummaryArray($userId);

            return [
                'message' => $formattedMessage,
            ];
        });
    }
}
