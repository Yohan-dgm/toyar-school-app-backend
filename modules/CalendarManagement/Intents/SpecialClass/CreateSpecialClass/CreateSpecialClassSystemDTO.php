<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\CreateSpecialClass;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSpecialClassSystemDTO extends Data
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
