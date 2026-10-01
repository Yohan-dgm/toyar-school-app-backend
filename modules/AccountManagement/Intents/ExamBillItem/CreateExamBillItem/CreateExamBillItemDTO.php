<?php

namespace Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamBillItemDTO extends Data
{
    public function __construct(
        public int $exam_bill_id,
        public int $exam_subject_category_id,

        // system
        public int $created_by,
        public string $rate_id_list,
        public string $rate_list,
        public float $subtotal,
        public float $total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'exam_bill_id' => [new Required],
            'exam_subject_category_id' => [new Required],

            // system
            'created_by' => [new Required],
            'rate_id_list' => [new Required],
            'rate_list' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],

        ];
    }
}
