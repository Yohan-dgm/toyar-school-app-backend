<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\UpdateStudentExamMark;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentExamMarkSystemDTO extends Data
{
    public function __construct(
        // system
        public bool $is_mark_added,
        public int $mark_added_by,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'mark_added_by' => [new Required, new IntegerType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
