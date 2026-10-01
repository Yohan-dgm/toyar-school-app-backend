<?php

namespace Modules\CommunicationManagement\Intents\Chat\ToggleChatGroupPin;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Http\Request;

class ToggleChatGroupPinAction
{
    use AsAction;

    public function handle(int $userId, int $chatGroupId)
    {
        $member = ChatGroupMember::where('user_id', $userId)
            ->where('chat_group_id', $chatGroupId)
            ->active()
            ->first();

        if (!$member) {
            return [
                'success' => false,
                'message' => 'User is not a member of this chat group.',
            ];
        }

        $member->update([
            'is_pinned' => !$member->is_pinned,
        ]);

        return [
            'success' => true,
            'message' => $member->is_pinned ? 'Chat pinned successfully.' : 'Chat unpinned successfully.',
            'data' => [
                'is_pinned' => $member->is_pinned,
            ],
        ];
    }

    public function asController(Request $request)
    {
        $request->validate([
            'chat_group_id' => 'required|integer',
        ]);

        return response()->json($this->handle(
            auth()->id(),
            $request->input('chat_group_id')
        ));
    }
}
