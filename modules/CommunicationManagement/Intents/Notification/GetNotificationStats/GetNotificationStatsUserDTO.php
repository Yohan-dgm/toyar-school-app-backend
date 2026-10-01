<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Spatie\LaravelData\Data;

class GetNotificationStatsUserDTO extends Data
{
    public function __construct(
        public ?string $date_range = null,         // optional: 'today', 'week', 'month', 'all'
        public ?array $priority_filter = null,    // optional: ['normal', 'high', 'urgent']
        public ?array $type_filter = null,        // optional: notification type IDs
        public bool $include_read = true,         // optional: include read notifications in stats
        public bool $include_archived = false,   // optional: include archived notifications
    ) {}

    public static function rules(): array
    {
        return [
            'date_range' => ['sometimes', 'string', 'in:today,week,month,all'],
            'priority_filter' => ['sometimes', 'array'],
            'priority_filter.*' => ['string', 'in:normal,high,urgent'],
            'type_filter' => ['sometimes', 'array'],
            'type_filter.*' => ['integer', 'min:1'],
            'include_read' => ['sometimes', 'boolean'],
            'include_archived' => ['sometimes', 'boolean'],
        ];
    }
}
