<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetNotificationDetailsUserDTO extends Data
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
