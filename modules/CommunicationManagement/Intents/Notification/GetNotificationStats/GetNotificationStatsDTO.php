<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Spatie\LaravelData\Data;

class GetNotificationStatsDTO extends Data
{
    public function __construct(
        public int $user_id,
        public string $requested_at,
        public ?string $date_range = null,
        public ?array $priority_filter = null,
        public ?array $type_filter = null,
        public bool $include_read = true,
        public bool $include_archived = false,
    ) {}

    public static function fromUserAndSystem(
        GetNotificationStatsUserDTO $userDTO,
        GetNotificationStatsSystemDTO $systemDTO
    ): self {
        return new self(
            user_id: $systemDTO->user_id,
            requested_at: $systemDTO->requested_at,
            date_range: $userDTO->date_range,
            priority_filter: $userDTO->priority_filter,
            type_filter: $userDTO->type_filter,
            include_read: $userDTO->include_read,
            include_archived: $userDTO->include_archived,
        );
    }
}
