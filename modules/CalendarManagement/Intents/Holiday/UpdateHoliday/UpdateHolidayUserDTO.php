<?php

namespace Modules\CalendarManagement\Intents\Holiday\UpdateHoliday;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateHolidayUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $title,
        public Date $date,
        public ?string $description,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "id" => [new Required(), new IntegerType()],
            "title" => [new Required(), new StringType()],
            "date" => [new Required()],

        ];
    }
}
