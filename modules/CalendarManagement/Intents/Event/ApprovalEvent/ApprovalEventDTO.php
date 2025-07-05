<?php

namespace Modules\CalendarManagement\Intents\Event\ApprovalEvent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ApprovalEventDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $visibility_type,

        // system
        public bool $is_approved,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "id" => [new Required(), new IntegerType()],
            "visibility_type" => [new Required(), new StringType()],

            // system
            "is_approved" =>  [new Required()],
            "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
