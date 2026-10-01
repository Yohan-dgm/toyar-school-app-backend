<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateInitialSectionUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $receipt_party,
        public mixed $student_id,
        public mixed $applicant_id,
        public mixed $exam_private_candidate_id,
        public mixed $private_candidate_id,
        public mixed $narration,
        public mixed $amount,
        public mixed $admission_fee_settlement,
        public mixed $refundable_deposit_settlement,
        public mixed $term_fee_settlement,
        public mixed $payment_method,
        public mixed $bank_account_id,
        public mixed $bank_deposit_date,
        public mixed $cash_account_id,
        public mixed $cash_received_date,
        public mixed $check_type,
        public mixed $check_bank_id,
        public mixed $check_number,
        public mixed $check_received_date,
        public mixed $check_date,
        public mixed $receipt_voucher_unsaved_attachment_list,
        public mixed $receipt_voucher_type,
        public mixed $exam_bill_id,
        public mixed $material_bill_id,
        public mixed $admission_fee_invoice_id,
        public mixed $term_fee_invoice_id,
        public mixed $refundable_deposit_id,
        public mixed $sport_fee_invoice_id,
        public mixed $sport_fee,
        public mixed $late_fee_charges,
        public mixed $old_bill_number,
        public mixed $applicant_proforma_invoice_id,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
