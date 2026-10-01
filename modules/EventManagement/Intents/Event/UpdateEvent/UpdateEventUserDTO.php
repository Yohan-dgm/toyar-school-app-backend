<?php

namespace Modules\EventManagement\Intents\Event\UpdateEvent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEventUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        public string $duration_type,
        public string $date,
        public ?string $start_time,
        public ?string $end_time,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'name' => [new Required, new StringType],
            'duration_type' => [new Required, new StringType],
            'date' => [new Required, new StringType],
            'start_time' => [new RequiredIf('duration_type', '=', 'Time Period'), new StringType],
            'end_time' => [new RequiredIf('duration_type', '=', 'Time Period'), new StringType],
        ];
    }
}
