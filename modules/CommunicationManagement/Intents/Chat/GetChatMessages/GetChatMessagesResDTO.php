<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatMessages;

class GetChatMessagesResDTO
{
    public array $messages;
    public array $pagination;

    public function __construct(array $messages, array $pagination)
    {
        $this->messages = $messages;
        $this->pagination = $pagination;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['messages'] ?? [],
            $data['pagination'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'messages' => $this->messages,
            'pagination' => $this->pagination,
        ];
    }

    public static function formatMessage(array $message): array
    {
        return [
            'id' => $message['id'] ?? 0,
            'chat_group_id' => $message['chat_group_id'] ?? 0,
            'user_id' => $message['user_id'] ?? 0,
            'sender_id' => $message['sender_id'] ?? $message['user_id'] ?? 0,
            'sender_name' => $message['sender_name'] ?? 'Unknown',
            'sender_role' => $message['sender_role'] ?? 'member',
            'type' => $message['type'] ?? 'text',
            'content' => $message['content'] ?? '',
            'attachment_url' => $message['attachment_url'] ?? null,
            'metadata' => $message['metadata'] ?? null,
            'is_read' => $message['is_read'] ?? false,
            'read_at' => $message['read_at'] ?? null,
            'read_count' => (int)($message['read_count'] ?? 0),
            'created_at' => $message['created_at'] ?? null,
            'timestamp' => $message['created_at'] ?? null,
            'reactions' => self::formatReactions($message['reactions'] ?? []),
        ];
    }

    private static function formatReactions(array $reactions): array
    {
        $formatted = [];
        foreach ($reactions as $reaction) {
            $emoji = $reaction['emoji'];
            if (!isset($formatted[$emoji])) {
                $formatted[$emoji] = [
                    'emoji' => $emoji,
                    'count' => 0,
                    'user_ids' => []
                ];
            }
            $formatted[$emoji]['count']++;
            $formatted[$emoji]['user_ids'][] = $reaction['user_id'];
        }
        return array_values($formatted);
    }
}
