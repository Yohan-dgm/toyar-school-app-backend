<?php

namespace Modules\AccountManagement\Intents\ExamBill\UpdateExamBill;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamBillUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public ?string $bill_party,
        public ?int $student_id,
        public ?int $exam_private_candidate_id,
        public ?string $bill_notes,
        public ?string $office_notes,
        public ?array $exam_bill_item_list,
        public ?float $additional_service_charge,
        public ?float $exam_bill_discount,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
        ];
    }
}
