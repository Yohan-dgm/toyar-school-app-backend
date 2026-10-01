<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponentType\UpdateExamSubjectComponentType;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamSubjectComponentTypeUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'name' => [new Required, new StringType],
        ];
    }
}
