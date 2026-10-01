<?php

namespace Modules\AccountManagement\Intents\ExamBill\UpdateExamBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamBillDTO extends Data
{
    public function __construct(
        public ?string $bill_party,
        public ?int $student_id,
        public ?int $exam_private_candidate_id,
        public ?string $bill_notes,
        public ?string $office_notes,
        public ?float $additional_service_charge,
        public ?float $exam_bill_discount,

        // system
        public float $exam_subjects_total,
        public float $exam_service_charges_total,
        public float $subtotal,
        public float $total,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'updated_by' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],

        ];
    }
}
