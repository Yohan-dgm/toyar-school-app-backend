<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAdmissionFeeInvoiceUserDTO extends Data
{
    public function __construct(
        // user
        public ?float $amount,
        public Date $date,
        public int $student_id,
        public float $discount_total,
        public ?float $service_charges_total,
        public ?string $order_notes,
        public ?string $office_notes,
        // public ?float $items_total,
        // public ?float $subtotal_before_discount,
        // public ?float $subtotal_after_discount,
        // public ?float $bill_total,
        // public ?int $school_fee_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
            'student_id' => [new Required],
        ];
    }
}
