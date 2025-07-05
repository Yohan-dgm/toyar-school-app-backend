<?php

namespace Modules\CalendarManagement\Intents\Event\CreateEvent;

use Ramsey\Uuid\Type\Time;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEventUserDTO extends Data
{
    public function __construct(
        // user
        public string $title,
        public int $event_category_id,
        public Date $start_date,
        public string $start_time,
        public date $end_date,
        public string $end_time,
        public ?string $description,
        public string $visibility_type,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "title" => [new Required(), new StringType()],
            "event_category_id" => [new Required(), new IntegerType()],
            "start_date" => [new Required()],
            "start_time" => [new Required()],
            "end_date" => [new Required()],
            "end_time" => [new Required()],
            "visibility_type" => [new Required(), new StringType()],
        ];
    }
}
