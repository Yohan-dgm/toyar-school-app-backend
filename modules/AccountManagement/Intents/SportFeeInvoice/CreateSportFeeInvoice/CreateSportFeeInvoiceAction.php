<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog\CreateInvoicesLogAction;
use Modules\SystemEntityManagement\Models\Term;

class CreateSportFeeInvoiceAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createSportFeeInvoiceUserDTO = CreateSportFeeInvoiceUserDTO::validate($payloadArray);

        $system_data['serial_number_prefix'] = 'NY/SP-INV';
        $maxDigits = SportFeeInvoice::where(function (Builder $receipt_query) {
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

        // $schoolFee = SchoolFee::where('school_fee_type', 'Sport Fee')->where('is_active', true)->first();
        // $system_data['items_total'] = $createSportFeeInvoiceUserDTO['items_total'];
        // $system_data['service_charges_total'] = 0;
        // $system_data['subtotal_before_discount'] =  $system_data['items_total'];
        // $system_data['subtotal_after_discount'] = $system_data['subtotal_before_discount'] - $createSportFeeInvoiceUserDTO['discount_total'];
        // $system_data['bill_total'] = $system_data['subtotal_after_discount'];
        $system_data['is_sport_fee_invoice_complete'] = false;
        $term_data = Term::where('is_current_term', true)->first();
        $system_data['term_id'] = $term_data->id;

        $createSportFeeInvoiceSystemDTO = CreateSportFeeInvoiceSystemDTO::validate($system_data);
        $createSportFeeInvoiceDTO = CreateSportFeeInvoiceDTO::validate(array_merge($createSportFeeInvoiceUserDTO, $createSportFeeInvoiceSystemDTO));
        $createdSportFeeInvoice = SportFeeInvoice::create($createSportFeeInvoiceDTO);

        $sportFeeInvoiceItemList = $createSportFeeInvoiceUserDTO['sport_fee_invoice_item_list'] ?? [];
        $items_total = 0;
        foreach ($sportFeeInvoiceItemList as $item) {
            // var_dump($item);
            $item['sport_fee_invoice_id'] = $createdSportFeeInvoice->id; // Assign sport_fee_invoice_id

            $createSportFeeInvoiceItemUserDTO = CreateSportFeeInvoiceItemUserDTO::validate($item);

            $sportFeeInvoiceItemActionData = ['created_by' => $actionData['created_by']];
            CreateSportFeeInvoiceItemAction::run($createSportFeeInvoiceItemUserDTO, $sportFeeInvoiceItemActionData);
            $items_total += $item['item_total'];
        }
        // $createdSportFeeInvoice = SportFeeInvoice::find($createdSportFeeInvoice->id);

        // create invoice log
        $logData['description'] = '[STATUS: Created Sport Fee Invoice, IP: '.$_SERVER['REMOTE_ADDR'].', INVOICE: .'.$createdSportFeeInvoice->serial_number.', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Sport Fee Invoice';
        CreateInvoicesLogAction::run($logData, ['created_by' => $actionData['created_by']]);

        return $createdSportFeeInvoice;
    }
}
