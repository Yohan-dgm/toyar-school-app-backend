<?php

namespace Modules\CalendarManagement\Intents\Holiday\CreateHoliday;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateHolidaySystemDTO extends Data
{
    public function __construct(
        public int $created_by
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            "created_by" =>  [new Required(), new IntegerType()]
        ];
    }
}
