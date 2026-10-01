<?php

namespace Modules\CalendarManagement\Intents\Calendar\GetCalendarDataByMonth;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCalendarDataByMonthUserDTO extends Data
{
    public function __construct(
        // user
        public string $month, // Format: YYYY-MM (e.g., "2024-03")
        // system

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'month' => [new Required, 'string', 'regex:/^\d{4}-\d{2}$/'],
            // system
        ];
    }
}
