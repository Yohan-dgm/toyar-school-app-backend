<?php

namespace Modules\CommunicationManagement\Intents\Chat\DeleteChatGroup;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class DeleteChatGroupAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $chatGroupId = $payloadArray['chat_group_id'] ?? null;
        $userId = $actionData['user_id'];
        
        if (!$chatGroupId) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Chat group ID is required.'],
            ]);
        }

        $group = ChatGroup::findOrFail($chatGroupId);

        // Only the creator or an admin member can delete the group
        $isAdmin = ChatGroupMember::where('chat_group_id', $chatGroupId)
            ->where('user_id', $userId)
            ->where('role', 'admin')
            ->where('is_active', true)
            ->exists();

        if ($group->created_by != $userId && !$isAdmin) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only the group creator or an admin can delete the group.'],
            ]);
        }

        // Broadcast deletion event to all members in the presence channel
        broadcast(new \App\Events\ChatGroupDeleted($group->id));

        DB::transaction(function () use ($group) {
            // Delete members
            ChatGroupMember::where('chat_group_id', $group->id)->delete();
            
            // Note: Messages will be deleted via cascade if the DB is set up that way,
            // or we could manually delete them here if needed.
            // For now, let's assume cascade or soft delete.
            
            $group->delete();
        });

        return [
            'success' => true,
            'message' => 'Group deleted successfully.',
        ];
    }
}
