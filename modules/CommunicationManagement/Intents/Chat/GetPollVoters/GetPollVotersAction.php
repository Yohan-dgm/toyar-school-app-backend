<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetPollVoters;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessagePoll;
use Modules\UserManagement\Models\User;

// The ONLY endpoint in the poll feature that ever reveals voter identity —
// enforced server-side (group admin only) regardless of what the frontend
// shows, since realtime broadcasts and GetPollDetailsAction deliberately
// never carry this data.
class GetPollVotersAction
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

        if (!$group->isAdmin($userId)) {
            throw ValidationException::withMessages([
                'chat_message_id' => ['Only group admins can view who voted.'],
            ]);
        }

        $poll = ChatMessagePoll::where('chat_message_id', $message->id)
            ->with(['options.votes'])
            ->firstOrFail();

        $allVoterIds = $poll->options->flatMap(fn ($option) => $option->votes->pluck('user_id'))->unique();

        $users = User::with(['profile_images' => function ($q) {
                $q->where('is_active', true)->orderBy('created_at', 'desc')->limit(1);
            }])
            ->whereIn('id', $allVoterIds)
            ->get()
            ->keyBy('id');

        $options = $poll->options->map(function ($option) use ($users) {
            $voters = $option->votes->map(function ($vote) use ($users) {
                $user = $users->get($vote->user_id);
                $name = $user?->full_name ?? $user?->name ?? ('User '.$vote->user_id);
                $profileImage = $user?->profile_images->first();

                return [
                    'user_id' => $vote->user_id,
                    'name' => $name,
                    'avatar' => $profileImage ? $profileImage->getFullUrl() : null,
                ];
            })->values()->toArray();

            return [
                'option_id' => $option->id,
                'option_text' => $option->option_text,
                'voters' => $voters,
            ];
        })->values()->toArray();

        return ['options' => $options];
    }
}
