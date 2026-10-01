<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateNotificationSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => 'required|integer|exists:user,id',
        ];
    }
}
