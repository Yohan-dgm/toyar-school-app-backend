<?php

namespace Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamBillItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $exam_bill_id,
        public int $exam_subject_category_id,
        public array $exam_subject_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'exam_bill_id' => [new Required],
            'exam_subject_category_id' => [new Required],
        ];
    }
}
