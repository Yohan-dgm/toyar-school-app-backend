<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\CompleteEducatorEnterMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompleteEducatorEnterMarkSystemDTO extends Data
{
    public function __construct(
        // system
        public int $updated_by,
        public bool $is_all_marks_confirmed,
        public int $confirmed_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
