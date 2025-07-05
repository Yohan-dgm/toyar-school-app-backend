<?php

namespace Modules\CalendarManagement\Intents\EventCategory\CreateEventCategory;

use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateEventCategoryUserDTO extends Data
{
    public function __construct(
        // user   
        public string $name,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user  
            "name" =>  [new Required(), new StringType()],
            // system 
        ];
    }
}
