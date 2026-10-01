<?php

namespace Modules\AccountManagement\Intents\ExamBill\CreateExamBill;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamBillDTO extends Data
{
    public function __construct(

        public Date $date,
        public ?string $bill_party,
        public ?int $student_id,
        public ?int $exam_private_candidate_id,
        public ?string $bill_notes,
        public ?string $office_notes,
        public ?array $exam_bill_item_list,
        public ?float $additional_service_charge,
        public ?float $exam_bill_discount,

        // system
        public float $exam_subjects_total,
        public float $exam_service_charges_total,
        public float $subtotal,
        public float $total,
        public int $created_by,
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
