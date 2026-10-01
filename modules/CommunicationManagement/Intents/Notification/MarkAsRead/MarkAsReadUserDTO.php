<?php

namespace Modules\CommunicationManagement\Intents\Notification\MarkAsRead;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class MarkAsReadUserDTO extends Data
{
    public function __construct(
        public int $notification_id,
        public ?bool $mark_all,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'notification_id' => 'required|integer|exists:notifications,id',
            'mark_all' => 'nullable|boolean',
        ];
    }
}
