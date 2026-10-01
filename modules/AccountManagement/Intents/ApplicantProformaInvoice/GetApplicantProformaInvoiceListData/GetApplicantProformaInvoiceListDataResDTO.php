<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\GetApplicantProformaInvoiceListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetApplicantProformaInvoiceListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $applicant_proforma_invoice_count,
        public ?object $payment_completed_invoices_count,
        public ?object $due_payment_invoices_count,
        public ?object $payment_due_invoice_total_amount,
        public ?object $invoice_total_amount,
        public ?object $total_invoice_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
