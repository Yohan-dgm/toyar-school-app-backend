<?php

namespace Modules\AccountManagement\Intents\ExamBill\UpdateExamBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamBillSystemDTO extends Data
{
    public function __construct(
        public float $exam_subjects_total,
        public float $exam_service_charges_total,
        public float $subtotal,
        public float $total,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],
        ];
    }
}
