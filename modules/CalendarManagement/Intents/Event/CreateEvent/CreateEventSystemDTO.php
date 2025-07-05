<?php

namespace Modules\CalendarManagement\Intents\Event\CreateEvent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEventSystemDTO extends Data
{
    public function __construct(
        public bool $is_approved,
        public ?string $request_visibility_type,
        public int $approved_by,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            "approved_by" =>  [new Required(), new IntegerType()],
            "is_approved" =>  [new Required()],
            "created_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
