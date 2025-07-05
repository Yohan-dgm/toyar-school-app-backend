<?php

namespace Modules\CalendarManagement\Intents\EventCategory\UpdateEventCategory;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateEventCategoryUserDTO extends Data
{
    public function __construct(
        // user   
        public int $id,
        public string $name,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user  
            "id" =>  [new Required(), new IntegerType()],
            "name" =>  [new Required(), new StringType()],
        ];
    }
}
