<?php

namespace Modules\CommunicationManagement\Intents\Chat\SetChatGroupVoiceNote;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;

// Dedicated, additive endpoint for the "allow voice notes in this group"
// admin toggle — new file, mirrors the existing admin-only-settings check
// already used by UpdateChatGroupAction, without editing that file.
class SetChatGroupVoiceNoteAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'is_voicenote' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userId = $actionData['user_id'];
        $group = ChatGroup::findOrFail($payloadArray['chat_group_id']);

        $member = ChatGroupMember::where('chat_group_id', $group->id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$member || $member->role !== 'admin') {
            throw ValidationException::withMessages([
                'chat_group_id' => ['Only group admins can update group settings.'],
            ]);
        }

        try {
            $group->update(['is_voicenote' => $payloadArray['is_voicenote']]);
        } catch (QueryException $e) {
            // is_voicenote's migration hasn't been applied to the database
            // yet — fail cleanly instead of leaking the raw SQL error
            // ("column does not exist") to the client.
            Log::error('SetChatGroupVoiceNoteAction: DB update failed (is_voicenote column likely not migrated yet)', [
                'chat_group_id' => $group->id,
                'error' => $e->getMessage(),
            ]);
            throw new Exception('Voice note settings are not available yet. Please try again later.');
        }

        broadcast(new \App\Events\ChatGroupUpdated($group->toArray()));

        return $group->toArray();
    }
}
