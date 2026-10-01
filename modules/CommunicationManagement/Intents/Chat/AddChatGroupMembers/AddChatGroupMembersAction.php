<?php

namespace Modules\CommunicationManagement\Intents\Chat\AddChatGroupMembers;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AddChatGroupMembersAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $dto = AddChatGroupMembersDTO::validate($payloadArray);
        $userId = $actionData['user_id'];
        
        $group = ChatGroup::findOrFail($dto['chat_group_id']);

        // Check if user is admin of the group
        $member = ChatGroupMember::where('chat_group_id', $group->id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$member || $member->role !== 'admin') {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only group admins can add members.'],
            ]);
        }

        DB::transaction(function () use ($group, $dto) {
            foreach ($dto['user_ids'] as $uid) {
                // Use updateOrCreate to reactivate if previously removed
                ChatGroupMember::updateOrCreate(
                    ['chat_group_id' => $group->id, 'user_id' => $uid],
                    ['is_active' => true, 'joined_at' => now(), 'role' => 'member']
                );
            }
        });

        return [
            'success' => true,
            'message' => 'Members added successfully.',
        ];
    }
}
