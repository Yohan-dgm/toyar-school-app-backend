<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAdmissionFeeInvoiceItemDTO extends Data
{
    public function __construct(
        public int $admission_fee_invoice_id,
        public ?float $school_fee_id,
        public ?string $description,
        public ?float $item_total,

        // system
        public ?bool $is_admission_fee_invoice_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'admission_fee_invoice_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
