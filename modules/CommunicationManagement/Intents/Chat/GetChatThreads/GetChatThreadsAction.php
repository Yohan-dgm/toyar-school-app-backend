<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatGroupMember;
use Modules\CommunicationManagement\Models\ChatMessage;
use Illuminate\Support\Facades\DB;

class GetChatThreadsAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): GetChatThreadsResDTO
    {
        // Validation
        $userDTO = GetChatThreadsUserDTO::validate($payloadArray);
        $systemDTO = GetChatThreadsSystemDTO::validate($actionData);
        $dto = GetChatThreadsDTO::validate(array_merge($userDTO, $systemDTO));

        $userId = $dto['user_id'];
        $page = $dto['page'] ?? 1;
        $perPage = $dto['per_page'] ?? 20;

        // Query chat groups where user is a member and both are active
        $query = ChatGroup::select('chat_groups.*')
            ->active()
            ->forUser($userId)
            ->with(['createdBy'])
            ->withCount(['members' => function ($q) {
                $q->where('is_active', true);
            }]);

        // Filter by type
        if (isset($dto['type']) && $dto['type'] !== 'all') {
            $query->where('chat_groups.type', $dto['type']);
        }

        // Search by group name
        if (isset($dto['search'])) {
            $search = $dto['search'];
            $query->where('chat_groups.name', 'ILIKE', "%{$search}%");
        }

        // Order by last message activity
        $query->leftJoin('chat_messages as cm', function ($join) {
            $join->on('chat_groups.id', '=', 'cm.chat_group_id')
                ->whereRaw('cm.id = (SELECT id FROM chat_messages WHERE chat_group_id = chat_groups.id ORDER BY created_at DESC LIMIT 1)');
        })
        ->orderByRaw('COALESCE(cm.created_at, chat_groups.created_at) DESC');

        $paginatedGroups = $query->paginate($perPage, ['*'], 'page', $page);

        $threads = $paginatedGroups->getCollection()->map(function ($group) use ($userId) {
            // Get last message
            $lastMessage = ChatMessage::where('chat_group_id', $group->id)
                ->join('user', 'chat_messages.user_id', '=', 'user.id')
                ->select('chat_messages.*', 'user.full_name as sender_name')
                ->latest()
                ->first();

            // Calculate unread count
            $member = ChatGroupMember::where('chat_group_id', $group->id)
                ->where('user_id', $userId)
                ->first();

            $unreadCount = $member ? ChatMessage::where('chat_group_id', $group->id)
                ->where('created_at', '>', $member->last_read_at ?? $member->joined_at ?? $member->created_at)
                ->where('user_id', '!=', $userId)
                ->count() : 0;

            // Handle Direct Chat Name (if direct, show other user's name)
            if ($group->type === 'direct' && empty($group->name)) {
                $otherMember = ChatGroupMember::where('chat_group_id', $group->id)
                    ->where('user_id', '!=', $userId)
                    ->join('user', 'chat_group_members.user_id', '=', 'user.id')
                    ->select('user.full_name')
                    ->first();
                
                $group->name = $otherMember->full_name ?? 'Deleted User';
            }

            // Include current user's role and creator name
            $group->current_user_role = $member->role ?? 'member';
            $group->created_by_name = $group->createdBy ? ($group->createdBy->full_name ?? $group->createdBy->name ?? 'Admin') : 'Admin';

            return GetChatThreadsResDTO::formatThread(
                $group->toArray(),
                $lastMessage ? $lastMessage->toArray() : null,
                $unreadCount,
                $member->is_pinned ?? false
            );
        })->toArray();

        return GetChatThreadsResDTO::fromArray([
            'threads' => $threads,
            'pagination' => [
                'current_page' => $paginatedGroups->currentPage(),
                'last_page' => $paginatedGroups->lastPage(),
                'per_page' => $paginatedGroups->perPage(),
                'total' => $paginatedGroups->total(),
                'has_more' => $paginatedGroups->hasMorePages(),
            ],
        ]);
    }
}
