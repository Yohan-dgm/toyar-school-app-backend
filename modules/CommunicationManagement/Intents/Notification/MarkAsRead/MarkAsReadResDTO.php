<?php

namespace Modules\CommunicationManagement\Intents\Notification\MarkAsRead;

use Spatie\LaravelData\Data;

class MarkAsReadResDTO extends Data
{
    public function __construct(
        public int $affected_count,
        public bool $success,
        public string $message,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            affected_count: $data['affected_count'],
            success: $data['success'],
            message: $data['message'],
        );
    }
}
