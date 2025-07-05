<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\UpdateSpecialClass;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSpecialClassSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            "updated_by" =>  [new Required()],
        ];
    }
}
