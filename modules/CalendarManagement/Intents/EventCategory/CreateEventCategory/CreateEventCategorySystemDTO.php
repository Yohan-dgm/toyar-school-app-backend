<?php

namespace Modules\CalendarManagement\Intents\EventCategory\CreateEventCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEventCategorySystemDTO extends Data
{
    public function __construct(
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            "created_by" =>  [new Required()],
        ];
    }
}
