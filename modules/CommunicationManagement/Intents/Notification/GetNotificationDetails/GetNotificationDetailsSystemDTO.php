<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetNotificationDetailsSystemDTO extends Data
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
