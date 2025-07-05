<?php

namespace Modules\CalendarManagement\Intents\Event\ApprovalEvent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ApprovalEventSystemDTO extends Data
{
    public function __construct(
        // system
        public bool $is_approved,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            "is_approved" =>  [new Required()],
            "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
