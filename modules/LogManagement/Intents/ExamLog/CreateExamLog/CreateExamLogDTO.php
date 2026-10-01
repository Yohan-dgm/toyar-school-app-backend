<?php

namespace Modules\LogManagement\Intents\ExamLog\CreateExamLog;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamLogDTO extends Data
{
    public function __construct(
        // user
        public string $description,
        public string $user_name,
        public string $type,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'description' => [new Required, new StringType],
            'user_name' => [new Required, new StringType],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
