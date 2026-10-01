<?php

namespace Modules\CommunicationManagement\Intents\Chat\MarkChatAsRead;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Models\ChatMessageReadReceipt;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use App\Events\ChatReadReceiptUpdated;

class MarkChatAsReadAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $chatGroupId = $payloadArray['chat_group_id'];

        $member = ChatGroupMember::where('chat_group_id', $chatGroupId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $now = now();

        // 1. Update the member's overall last read time
        $member->update([
            'last_read_at' => $now,
        ]);

        $newlyReadMessageIds = [];

        // 2. Record read receipts for all messages in this group that haven't been read by this user yet
        // Check if table exists first (for robustness across tenants)
        if (Schema::hasTable('chat_message_read_receipts')) {
            // We look for messages where a receipt doesn't exist for this user.
            $unreadMessages = ChatMessage::where('chat_messages.chat_group_id', $chatGroupId)
                ->where('user_id', '!=', $userId) // Don't mark own messages as read (redundant)
                ->whereNotExists(function ($query) use ($userId) {
                    $query->select(DB::raw(1))
                        ->from('chat_message_read_receipts')
                        ->whereColumn('chat_message_read_receipts.chat_message_id', 'chat_messages.id')
                        ->where('chat_message_read_receipts.user_id', $userId);
                })
                ->get();
    
            foreach ($unreadMessages as $message) {
                ChatMessageReadReceipt::create([
                    'chat_message_id' => $message->id,
                    'user_id' => $userId,
                    'read_at' => $now,
                ]);
                $newlyReadMessageIds[] = (int)$message->id;
            }
        }

        // 3. Broadcast real-time update to the group if any messages were read
        if (!empty($newlyReadMessageIds)) {
            broadcast(new ChatReadReceiptUpdated(
                (int)$chatGroupId,
                (int)$userId,
                $newlyReadMessageIds,
                $now->toIso8601String()
            ));
        }

        return [
            'chat_group_id' => $chatGroupId,
            'last_read_at' => $member->last_read_at,
            'read_message_ids' => $newlyReadMessageIds,
        ];
    }
}
