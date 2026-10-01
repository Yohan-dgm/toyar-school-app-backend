<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\CreateApplicantProformaInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateApplicantProformaInvoiceItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $applicant_proforma_invoice_id,
        public ?string $invoice_type,
        public ?float $amount,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'applicant_proforma_invoice_id' => [new Required],
        ];
    }
}
