<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\UpdateAdmissionFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateAdmissionFeeInvoiceSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_admission_fee_invoice_complete,
        public ?float $items_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
