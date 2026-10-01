<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\UpdateApplicantProformaInvoice;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateApplicantProformaInvoiceSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_applicant_proforma_invoice_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
