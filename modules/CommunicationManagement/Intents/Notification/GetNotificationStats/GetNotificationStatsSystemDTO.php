<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Spatie\LaravelData\Data;

class GetNotificationStatsSystemDTO extends Data
{
    public function __construct(
        public int $user_id,
        public string $requested_at,
    ) {}

    public static function fromUserDTO(GetNotificationStatsUserDTO $userDTO, int $userId): self
    {
        return new self(
            user_id: $userId,
            requested_at: now()->toISOString(),
        );
    }
}
