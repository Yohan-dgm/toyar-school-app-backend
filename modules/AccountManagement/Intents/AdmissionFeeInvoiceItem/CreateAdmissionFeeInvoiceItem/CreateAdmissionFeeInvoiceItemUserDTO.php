<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAdmissionFeeInvoiceItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $admission_fee_invoice_id,
        public ?float $school_fee_id,
        public ?string $description,
        public ?float $item_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'admission_fee_invoice_id' => [new Required],
        ];
    }
}
