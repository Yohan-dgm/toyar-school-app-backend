<?php

namespace Modules\CommunicationManagement\Intents\Chat\RemoveChatGroupMember;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Validation\ValidationException;

class RemoveChatGroupMemberAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $dto = RemoveChatGroupMemberDTO::validate($payloadArray);
        $userId = $actionData['user_id'];
        
        $group = ChatGroup::findOrFail($dto['chat_group_id']);

        // Check if user is admin of the group
        $adminMember = ChatGroupMember::where('chat_group_id', $group->id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$adminMember || $adminMember->role !== 'admin') {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only group admins can remove members.'],
            ]);
        }

        // Deactivate the member
        $memberToRemove = ChatGroupMember::where('chat_group_id', $group->id)
            ->where('user_id', $dto['user_id'])
            ->first();

        if ($memberToRemove) {
            $memberToRemove->update([
                'is_active' => false,
                'deleted_at' => now(),
            ]);
        }

        return [
            'success' => true,
            'message' => 'Member removed successfully.',
        ];
    }
}
