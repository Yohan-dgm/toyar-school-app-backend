<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;
use Modules\SystemEntityManagement\Models\Term;

class CreateTermFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createTermFeeInvoiceUserDTO = CreateTermFeeInvoiceUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/TF-INV';
        $maxDigits = TermFeeInvoice::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
            $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
        })->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_financial_year'].'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }

        $system_data['created_by'] = $actionData['created_by'];
        $schoolFee = SchoolFee::where('school_fee_type', 'Term Fee')
            ->where('grade_level_id', $createTermFeeInvoiceUserDTO['grade_level_id'])
            ->where('is_active', true)->first();
        $schoolFee == null ? $schoolFeeAmount = 0 : $schoolFeeAmount = $schoolFee->amount;
        $system_data['items_total'] = $schoolFeeAmount;
        // $system_data['service_charges_total'] = 0;
        $system_data['subtotal_before_discount'] = $schoolFeeAmount;
        $system_data['subtotal_after_discount'] = $system_data['subtotal_before_discount'] - $createTermFeeInvoiceUserDTO['discount_total'];
        $system_data['bill_total'] = $createTermFeeInvoiceUserDTO['amount'];
        $system_data['is_term_fee_invoice_complete'] = false;
        $term_data = Term::where('is_current_term', true)->first();
        $system_data['term_id'] = $term_data->id;
        // var_dump($createTermFeeInvoiceUserDTO['amount']);

        $createTermFeeInvoiceSystemDTO = CreateTermFeeInvoiceSystemDTO::validate($system_data);
        $createTermFeeInvoiceDTO = CreateTermFeeInvoiceDTO::validate(array_merge($createTermFeeInvoiceUserDTO, $createTermFeeInvoiceSystemDTO));
        $createdTermFeeInvoice = TermFeeInvoice::create($createTermFeeInvoiceDTO);

        // $termFeeInvoiceItemList = $createTermFeeInvoiceUserDTO['term_fee_invoice_item_list'] ?? [];
        // foreach ($termFeeInvoiceItemList as $item) {
        $termFeeItemData = [];
        $termFeeItemData['school_fee_id'] = ($schoolFee == null) ? 0 : $schoolFee->id;
        $termFeeItemData['description'] = ($schoolFee == null) ? 'Term Fee' : $schoolFee->name;
        $termFeeItemData['item_total'] = $schoolFeeAmount;
        $termFeeItemData['term_id'] = $term_data->id;
        $termFeeItemData['grade_level_id'] = $createTermFeeInvoiceUserDTO['grade_level_id'];

        $termFeeItemData['term_fee_invoice_id'] = $createdTermFeeInvoice->id; // Assign term_fee_invoice_id
        $createTermFeeInvoiceItemUserDTO = CreateTermFeeInvoiceItemUserDTO::validate($termFeeItemData);
        $termFeeInvoiceItemActionData = ['created_by' => $actionData['created_by']];
        CreateTermFeeInvoiceItemAction::run($createTermFeeInvoiceItemUserDTO, $termFeeInvoiceItemActionData);
        // }

        // $createdTermFeeInvoice = TermFeeInvoice::find($createdTermFeeInvoice->id);

        // create invoice log
        $logData['description'] = '[STATUS: Created Term Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdTermFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Term Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdTermFeeInvoice;
    }
}
