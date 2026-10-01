<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatGroupMembers;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\ValidationException;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Modules\UserManagement\Models\User;

class GetChatGroupMembersAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        // 1. Defensively extract and cast the group ID
        $chatGroupId = $payloadArray['chat_group_id'] ?? null;
        if (!$chatGroupId) {
            return [
                'members' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 20,
                    'total' => 0,
                    'has_more' => false,
                ]
            ];
        }

        // Only members of this group may view its member list (same rule
        // GetChatGroupMediaAction and every other per-group read already
        // enforces). Checked directly against ChatGroupMember (no separate
        // ChatGroup::findOrFail lookup), so a nonexistent/deleted group ID
        // just fails this same check rather than throwing a different
        // "not found" error — doesn't reveal whether the group exists.
        $isRequesterMember = ChatGroupMember::where('chat_group_id', $chatGroupId)
            ->where('user_id', $actionData['user_id'])
            ->where('is_active', true)
            ->exists();

        if (!$isRequesterMember) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['You are not a member of this chat group.'],
            ]);
        }

        $page = (int)($payloadArray['page'] ?? 1);
        $perPage = (int)($payloadArray['per_page'] ?? 20);

        // 2. Fetch active members using pagination
        $paginatedMembers = ChatGroupMember::where('chat_group_id', $chatGroupId)
            ->where('is_active', true)
            ->orderBy('joined_at', 'asc') // Sort by joined date or name
            ->paginate($perPage, ['*'], 'page', $page);

        $memberRecords = $paginatedMembers->getCollection();

        if ($memberRecords->isEmpty()) {
            return [
                'members' => [],
                'pagination' => [
                    'current_page' => $paginatedMembers->currentPage(),
                    'last_page' => $paginatedMembers->lastPage(),
                    'per_page' => $paginatedMembers->perPage(),
                    'total' => $paginatedMembers->total(),
                    'has_more' => $paginatedMembers->hasMorePages(),
                ]
            ];
        }

        // 3. Collect User IDs and fetch them in a separate query
        $userIds = $memberRecords->pluck('user_id')->toArray();
        
        $userRecords = User::with(['profile_images' => function($q) {
                $q->where('is_active', true)->orderBy('created_at', 'desc')->limit(1);
            }])
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        // 4. Map records to the expected interface
        $formattedMembers = $memberRecords->map(function ($member) use ($userRecords) {
            $user = $userRecords->get($member->user_id);
            
            $id = $member->user_id;
            $name = 'User ' . $id;
            $avatar = null;
            $userRoleLabel = 'member';

            if ($userRecord = $user) {
                $name = $userRecord->full_name ?? $userRecord->name ?? $userRecord->username ?? $name;
                $profileImage = $userRecord->profile_images->first();
                $avatar = $profileImage ? $profileImage->getFullUrl() : null;
                $userRoleLabel = $this->getRoleLabel($userRecord->user_category);
            }

            return [
                'id' => (string)$id,
                'name' => $name,
                'avatar' => $avatar,
                'role' => $member->role ?? 'member',
                'user_role_label' => $userRoleLabel,
            ];
        });

        return [
            'members' => $formattedMembers->values()->toArray(),
            'pagination' => [
                'current_page' => $paginatedMembers->currentPage(),
                'last_page' => $paginatedMembers->lastPage(),
                'per_page' => $paginatedMembers->perPage(),
                'total' => $paginatedMembers->total(),
                'has_more' => $paginatedMembers->hasMorePages(),
            ]
        ];
    }

    private function getRoleLabel($category): string
    {
        return match ((int)$category) {
            1 => 'parent',
            2 => 'teacher',
            4 => 'management',
            5 => 'student',
            default => 'user',
        };
    }
}
