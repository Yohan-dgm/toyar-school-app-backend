<?php

namespace Modules\LogManagement\Intents\StudentLog\CreateStudentLog;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentLogUserDTO extends Data
{
    public function __construct(
        // user
        public string $description,
        public string $user_name,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'description' => [new Required, new StringType],
            'user_name' => [new Required, new StringType],
        ];
    }
}
