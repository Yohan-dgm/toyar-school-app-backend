<?php

namespace Modules\CommunicationManagement\Intents\Notification\DeleteNotification;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteNotificationUserDTO extends Data
{
    public function __construct(
        public int $notification_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'notification_id' => 'required|integer|exists:notifications,id',
        ];
    }
}
