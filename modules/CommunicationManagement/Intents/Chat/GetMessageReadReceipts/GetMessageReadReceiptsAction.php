<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetMessageReadReceipts;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessageReadReceipt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetMessageReadReceiptsAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'message_id' => 'required|integer|exists:chat_messages,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $messageId = $payloadArray['message_id'];

        $message = ChatMessage::findOrFail($messageId);
        $group = $message->group;

        // Verify if requester is admin or member of the group
        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'message_id' => ['You are not authorized to view receipts for this message.'],
            ]);
        }

        // Only admins can see full read receipts list as requested
        // (Though the user might want members to see it too, but they explicitly said "admin need feature")
        if (!$group->isAdmin($userId)) {
             throw ValidationException::withMessages([
                'message_id' => ['Only admins can see who read the message.'],
            ]);
        }

        if (!Schema::hasTable('chat_message_read_receipts')) {
            return [
                'message_id' => $messageId,
                'read_by' => [],
            ];
        }

        $receipts = ChatMessageReadReceipt::where('chat_message_id', $messageId)
            ->with(['user:id,full_name'])
            ->get();
    
        return [
            'message_id' => $messageId,
            'read_by' => $receipts->map(function ($receipt) {
                return [
                    'user_id' => $receipt->user_id,
                    'user_name' => $receipt->user->full_name ?? 'Unknown',
                    'user_avatar' => null,
                    'read_at' => $receipt->read_at,
                ];
            })->toArray(),
        ];
    }
}
