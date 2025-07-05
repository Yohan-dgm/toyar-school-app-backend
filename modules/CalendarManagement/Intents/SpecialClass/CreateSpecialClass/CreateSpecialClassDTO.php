<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\CreateSpecialClass;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSpecialClassDTO extends Data
{
    public function __construct(
        // user 
        public string $title,
        public int $program_id,
        public int $subject_id,
        public Date $special_class_date,
        public string $start_time,
        public string $end_time,
        public ?string $description,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user    
            "title" =>  [new Required(), new StringType()],
            "program_id" =>  [new Required(), new IntegerType()],
            "subject_id" =>  [new Required(), new IntegerType()],
            "special_class_date" =>  [new Required()],
            "start_time" =>  [new Required()],
            "end_time" =>  [new Required()],
            // "description" =>  [new Required()],

            // system
            "created_by" =>  [new Required()],
        ];
    }
}
