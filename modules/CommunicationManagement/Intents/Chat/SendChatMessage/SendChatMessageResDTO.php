<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

class SendChatMessageResDTO
{
    public array $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['message'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
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
            'sender_avatar' => $message['sender_avatar'] ?? null,
            'type' => $message['type'] ?? 'text',
            'content' => $message['content'] ?? '',
            'attachment_url' => $message['attachment_url'] ?? null,
            'metadata' => $message['metadata'] ?? null,
            'created_at' => $message['created_at'] ?? null,
            'timestamp' => $message['created_at'] ?? null,
            'is_read' => false,
            'read_at' => null,
            'read_count' => 0,
            'reactions' => [],
        ];
    }
}
