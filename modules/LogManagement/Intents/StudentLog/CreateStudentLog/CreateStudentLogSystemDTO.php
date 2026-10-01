<?php

namespace Modules\LogManagement\Intents\StudentLog\CreateStudentLog;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentLogSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
