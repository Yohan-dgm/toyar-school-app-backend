<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\GetApplicantProformaInvoiceItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetApplicantProformaInvoiceItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $applicant_proforma_invoice_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
