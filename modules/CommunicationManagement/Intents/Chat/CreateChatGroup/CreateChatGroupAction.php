<?php

namespace Modules\CommunicationManagement\Intents\Chat\CreateChatGroup;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Illuminate\Support\Facades\DB;

use Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData\GetNotificationUserTypeListDataAction;

class CreateChatGroupAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): array
    {
        $dto = CreateChatGroupUserDTO::validate($payloadArray);
        $userId = $actionData['user_id'];
        
        // Resolve target users if category/selection is provided
        $resolvedIds = [];
        if (!empty($dto['category'])) {
            $resolutionPayload = [
                'group_filter' => $dto['category'],
                'grade_level_id' => $dto['grade_level_id'] ?? null,
                'grade_level_class_id' => $dto['grade_level_class_id'] ?? null,
                'student_ids' => $dto['student_ids'] ?? null,
            ];
            
            // Map common display names to backend keys if needed (matches announcement logic)
            $map = [
                'all' => 'All',
                'educator' => 'Educator',
                'management' => 'Management',
                'grade_level' => 'Grade_Level',
                'class' => 'Grade_Level_class',
            ];
            
            if (isset($map[$dto['category']])) {
                $resolutionPayload['group_filter'] = $map[$dto['category']];
            }
            
            $resolvedUsers = GetNotificationUserTypeListDataAction::run($resolutionPayload, []);
            $resolvedIds = $resolvedUsers->pluck('id')->toArray();
        }

        $participantIds = array_unique(array_merge([$userId], $dto['user_ids'] ?? [], $resolvedIds));

        return DB::transaction(function () use ($dto, $userId, $participantIds) {
            // If direct, check if exists
            if ($dto['type'] === 'direct' && count($participantIds) === 2) {
                $existingGroup = ChatGroup::where('type', 'direct')
                    ->whereHas('members', function($q) use ($participantIds) {
                        $q->whereIn('user_id', $participantIds);
                    }, '=', 2)
                    ->first();

                if ($existingGroup) {
                    return $existingGroup->toArray();
                }
            }

            // Create Group
            $group = ChatGroup::create([
                'name' => $dto['name'] ?? null,
                'type' => $dto['type'],
                'avatar_url' => $dto['avatar_url'] ?? null,
                'created_by' => $userId,
                'is_disabled' => $dto['is_disabled'] ?? false,
                'only_admins_can_message' => $dto['only_admins_can_message'] ?? true,
            ]);

            // Add Members
            foreach ($participantIds as $id) {
                ChatGroupMember::create([
                    'chat_group_id' => $group->id,
                    'user_id' => $id,
                    'role' => ($id === $userId) ? 'admin' : 'member',
                    'joined_at' => now(),
                ]);
            }

            return $group->toArray();
        });
    }
}
