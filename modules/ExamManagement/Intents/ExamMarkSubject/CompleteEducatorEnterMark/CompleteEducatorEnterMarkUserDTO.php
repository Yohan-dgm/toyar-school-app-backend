<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\CompleteEducatorEnterMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompleteEducatorEnterMarkUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
        ];
    }
}
