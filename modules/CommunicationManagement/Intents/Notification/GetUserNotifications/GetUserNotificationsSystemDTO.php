<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetUserNotifications;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetUserNotificationsSystemDTO extends Data
{
    public function __construct(
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => 'required|integer|exists:user,id',
        ];
    }
}
