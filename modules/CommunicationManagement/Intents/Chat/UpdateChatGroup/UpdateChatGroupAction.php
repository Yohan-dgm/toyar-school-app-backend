<?php

namespace Modules\CommunicationManagement\Intents\Chat\UpdateChatGroup;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Validation\ValidationException;

class UpdateChatGroupAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $dto = UpdateChatGroupDTO::validate($payloadArray);
        $userId = $actionData['user_id'];
        
        $group = ChatGroup::findOrFail($dto['chat_group_id']);

        // Check if user is admin of the group
        $member = ChatGroupMember::where('chat_group_id', $group->id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$member || $member->role !== 'admin') {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only group admins can update group settings.'],
            ]);
        }

        // Update group
        $updateData = [];
        if (isset($dto['name'])) $updateData['name'] = $dto['name'];
        if (isset($dto['avatar_url'])) $updateData['avatar_url'] = $dto['avatar_url'];
        if (isset($dto['is_disabled'])) $updateData['is_disabled'] = $dto['is_disabled'];
        if (isset($dto['only_admins_can_message'])) $updateData['only_admins_can_message'] = $dto['only_admins_can_message'];

        if (!empty($updateData)) {
            $group->update($updateData);
            
            // Broadcast group update
            broadcast(new \App\Events\ChatGroupUpdated($group->toArray()));
        }

        return $group->toArray();
    }
}
