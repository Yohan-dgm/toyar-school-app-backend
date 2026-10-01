<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetUserNotifications;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetUserNotificationsDTO extends Data
{
    public function __construct(
        public ?int $page,
        public ?int $per_page,
        public ?string $filter,
        public ?string $priority,
        public ?int $type_id,
        public ?string $search,
        public ?bool $unread_only,
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'filter' => 'nullable|in:all,read,unread,delivered,pending',
            'priority' => 'nullable|in:normal,high,urgent',
            'type_id' => 'nullable|integer|exists:notification_types,id',
            'search' => 'nullable|string|max:255',
            'unread_only' => 'nullable|boolean',
            'user_id' => 'required|integer|exists:user,id',
        ];
    }
}
