<?php

namespace Modules\AccountManagement\Intents\ExamBill\CreateExamBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamBillSystemDTO extends Data
{
    public function __construct(
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
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
