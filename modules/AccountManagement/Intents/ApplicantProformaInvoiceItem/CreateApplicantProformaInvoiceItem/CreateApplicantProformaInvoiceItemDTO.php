<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateApplicantProformaInvoiceItemDTO extends Data
{
    public function __construct(
        public int $applicant_proforma_invoice_id,
        public ?string $invoice_type,
        public ?float $amount,

        // system
        public ?string $print_invoice_type,
        public ?float $print_amount,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'applicant_proforma_invoice_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
