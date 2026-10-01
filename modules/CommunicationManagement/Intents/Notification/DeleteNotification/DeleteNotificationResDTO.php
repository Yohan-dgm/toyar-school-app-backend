<?php

namespace Modules\CommunicationManagement\Intents\Notification\DeleteNotification;

use Spatie\LaravelData\Data;

class DeleteNotificationResDTO extends Data
{
    public function __construct(
        public bool $success,
        public string $message,
        public int $notification_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            success: $data['success'],
            message: $data['message'],
            notification_id: $data['notification_id'],
        );
    }
}
