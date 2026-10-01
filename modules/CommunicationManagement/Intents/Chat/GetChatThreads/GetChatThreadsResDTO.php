<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

class GetChatThreadsResDTO
{
    public array $threads;
    public array $pagination;

    public function __construct(array $threads, array $pagination)
    {
        $this->threads = $threads;
        $this->pagination = $pagination;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['threads'] ?? [],
            $data['pagination'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'threads' => $this->threads,
            'pagination' => $this->pagination,
        ];
    }

    public static function formatThread(array $group, ?array $lastMessage = null, int $unreadCount = 0, bool $isPinned = false): array
    {
        return [
            'id' => $group['id'],
            'name' => $group['name'] ?? 'Direct Chat',
            'type' => $group['type'] ?? 'direct',
            'avatar_url' => $group['avatar_url'] ?? null,
            'unread_count' => $unreadCount,
            'is_pinned' => $isPinned,
            'is_disabled' => $group['is_disabled'] ?? false,
            'only_admins_can_message' => $group['only_admins_can_message'] ?? true, // Fallback to true per the new feature's default
            'is_voicenote' => $group['is_voicenote'] ?? true, // Fallback to true (voice notes enabled by default)
            'members_count' => $group['members_count'] ?? 0,
            'current_user_role' => $group['current_user_role'] ?? 'member',
            'last_message' => $lastMessage ? [
                'id' => $lastMessage['id'],
                'content' => $lastMessage['content'] ?? '',
                'type' => $lastMessage['type'] ?? 'text',
                'sender_id' => $lastMessage['user_id'] ?? null,
                'sender_name' => $lastMessage['sender_name'] ?? 'Unknown',
                'created_at' => $lastMessage['created_at'] ?? null,
                'timestamp' => $lastMessage['created_at'] ?? null,
            ] : null,
            'created_at' => $group['created_at'] ?? null,
            'updated_at' => $group['updated_at'] ?? null,
            'created_by_name' => $group['created_by_name'] ?? 'Admin',
        ];
    }
}
