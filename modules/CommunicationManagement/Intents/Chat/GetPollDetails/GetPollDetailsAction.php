<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetPollDetails;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessagePoll;

// Batched, aggregate-only poll hydration for whatever poll messages are
// currently loaded in a chat (cold-start / scroll-back). Never returns voter
// identities — see GetPollVotersAction for the admin-only equivalent.
class GetPollDetailsAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_message_ids' => 'required|array|min:1|max:100',
            'chat_message_ids.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $messageIds = array_values(array_unique(array_map('intval', $payloadArray['chat_message_ids'])));

        $messages = ChatMessage::whereIn('id', $messageIds)
            ->where('type', 'poll')
            ->get()
            ->keyBy('id');

        if ($messages->isEmpty()) {
            return ['polls' => []];
        }

        // Only include polls belonging to groups the requester is actually
        // a member of — silently skip the rest rather than erroring the
        // whole batch.
        $memberGroupIds = ChatGroup::query()
            ->forUser($userId)
            ->whereIn('id', $messages->pluck('chat_group_id')->unique())
            ->pluck('id')
            ->flip();

        $accessibleMessages = $messages->filter(fn (ChatMessage $m) => $memberGroupIds->has($m->chat_group_id));

        $polls = ChatMessagePoll::whereIn('chat_message_id', $accessibleMessages->keys())
            ->get()
            ->keyBy('chat_message_id');

        $result = [];
        foreach ($accessibleMessages as $messageId => $message) {
            $poll = $polls->get($messageId);
            if (!$poll) {
                continue;
            }
            $result[] = [
                'chat_message_id' => $messageId,
                'poll' => $poll->toSummaryArray($userId),
            ];
        }

        return ['polls' => $result];
    }
}
