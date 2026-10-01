<?php

namespace Modules\CalendarManagement\Intents\Calendar\GetCalendarDataByMonth;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCalendarDataByMonthResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $events,
        public ?array $holidays,
        public ?array $special_classes,
        public string $month,
        public string $start_date,
        public string $end_date,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
