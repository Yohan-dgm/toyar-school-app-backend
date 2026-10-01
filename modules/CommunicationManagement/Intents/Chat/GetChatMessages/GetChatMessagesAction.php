<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatMessages;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class GetChatMessagesAction
{
    use AsAction;

    public function handle(array $payloadArray, array $actionData): GetChatMessagesResDTO
    {
        // Validation
        $userDTO = GetChatMessagesUserDTO::validate($payloadArray);
        $systemDTO = GetChatMessagesSystemDTO::validate($actionData);
        $dto = GetChatMessagesDTO::validate(array_merge($userDTO, $systemDTO));

        $userId = $dto['user_id'];
        $chatGroupId = $dto['chat_group_id'];
        $page = $dto['page'] ?? 1;
        $perPage = $dto['per_page'] ?? 20;

        // Verify membership
        $group = ChatGroup::active()->findOrFail($chatGroupId);
        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['You are not a member of this chat group.'],
            ]);
        }

        // Check if read receipts table exists to prevent crash on new tenants
        $hasReceiptsTable = Schema::hasTable('chat_message_read_receipts');
        
        // Fetch messages with sender info and role in the group
        $query = ChatMessage::where('chat_messages.chat_group_id', $chatGroupId)
            ->leftJoin('user', 'chat_messages.user_id', '=', 'user.id')
            ->leftJoin('chat_group_members as cgm', function($join) use ($chatGroupId) {
                $join->on('chat_messages.user_id', '=', 'cgm.user_id')
                    ->where('cgm.chat_group_id', '=', $chatGroupId);
            });

        $columns = [
            'chat_messages.*',
            'user.full_name as sender_name',
            'cgm.role as sender_role'
        ];

        if ($hasReceiptsTable) {
            $columns[] = DB::raw('(SELECT COUNT(*) FROM chat_message_read_receipts WHERE chat_message_id = chat_messages.id) as read_count');
        }

        $paginatedMessages = $query->select($columns)
            ->orderBy('chat_messages.created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Check if reactions table exists
        $hasReactionsTable = Schema::hasTable('chat_message_reactions');

        if ($hasReactionsTable) {
            $paginatedMessages->load('reactions'); // Eager load reactions on the collection
        }

        $messages = $paginatedMessages->getCollection()->map(function ($message) {
            return GetChatMessagesResDTO::formatMessage($message->toArray());
        })->toArray();

        return GetChatMessagesResDTO::fromArray([
            'messages' => array_values($messages), // Newest first for inverted FlatList
            'pagination' => [
                'current_page' => $paginatedMessages->currentPage(),
                'last_page' => $paginatedMessages->lastPage(),
                'per_page' => $paginatedMessages->perPage(),
                'total' => $paginatedMessages->total(),
                'has_more' => $paginatedMessages->hasMorePages(),
            ],
        ]);
    }
}
