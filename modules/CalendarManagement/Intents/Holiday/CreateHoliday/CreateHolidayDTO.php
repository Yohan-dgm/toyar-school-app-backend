<?php

namespace Modules\CalendarManagement\Intents\Holiday\CreateHoliday;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateHolidayDTO extends Data
{
    public function __construct(
        // user
        public string $title,
        public Date $date,
        public ?string $description,

        // system
        public int $created_by,
    ) {}
    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "title" => [new Required(), new StringType()],
            "date" => [new Required()],

            // system
            "created_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
