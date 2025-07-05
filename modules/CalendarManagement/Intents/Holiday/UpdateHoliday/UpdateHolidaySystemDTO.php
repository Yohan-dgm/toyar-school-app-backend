<?php

namespace Modules\CalendarManagement\Intents\Holiday\UpdateHoliday;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateHolidaySystemDTO extends Data
{
    public function __construct(
        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
