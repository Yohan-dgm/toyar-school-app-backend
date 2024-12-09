<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;

class CreateInitialSectionAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $userDTO = CreateInitialSectionUserDTO::validate($payloadArray);

        // Data Prep
        $data = [];
        $data['receipt_party'] = $userDTO['receipt_party'];
        if ($data['receipt_party'] == "Student") {
            $data['student_id'] = $userDTO['student_id'];
        }
        if ($data['receipt_party'] == "Applicant") {
            $data['applicant_id'] = $userDTO['applicant_id'];
        }
        $data['narration'] = $userDTO['narration'];
        $data['amount'] = $userDTO['amount'];
        $data['payment_method'] = $userDTO['payment_method'];
        if ($data['payment_method'] == "Bank Deposit") {
            $data['bank_account_id'] = $userDTO['bank_account_id'];
            $data['bank_deposit_date'] = $userDTO['bank_deposit_date'];
            $data['payment_received_date'] = $userDTO['bank_deposit_date'];
        }
        if ($data['payment_method'] == "Cash") {
            $data['cash_account_id'] = $userDTO['cash_account_id'];
            $data['cash_received_date'] = $userDTO['cash_received_date'];
            $data['payment_received_date'] = $userDTO['cash_received_date'];
        }
        if ($data['payment_method'] == "Check") {
            $data['check_type'] = $userDTO['check_type'];
            $data['check_bank_id'] = $userDTO['check_bank_id'];
            $data['check_number'] = $userDTO['check_number'];
            $data['check_received_date'] = $userDTO['check_received_date'];
            $data['payment_received_date'] = $userDTO['check_received_date'];
            $data['check_date'] = $userDTO['check_date'];
        }
        $data['payment_received_by_id'] = $userDTO['payment_received_by_id'];

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['user_id'];
        $system_data['receipt_voucher_status_type_id'] = 1;
        $system_data['serial_number_prefix'] = "NY/REC";

        $maxDigits = ReceiptVoucher::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
            $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
        })->max("serial_number_digits");

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
        }

        // Final Data Validation
        $createInitialSectionDTO = CreateInitialSectionDTO::validate(array_merge($data, $system_data));

        // Save In Database
        $receiptVoucher = ReceiptVoucher::create($createInitialSectionDTO);

        return $receiptVoucher;
    }
}
