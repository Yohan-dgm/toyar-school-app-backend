<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\CreateExpenseParty;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseParty;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class CreateExpensePartyAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        // User Data Validation
        $createExpensePartyUserDTO = CreateExpensePartyUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        if ($createExpensePartyUserDTO['expense_party_type'] == 'Organization') {
            $system_data['name_with_title'] = 'M/s. '.$createExpensePartyUserDTO['name'];
        } else {
            $personTitle = PersonTitle::find($createExpensePartyUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$createExpensePartyUserDTO['name'];
        }

        $system_data['serial_number_prefix'] = 'NEXIS/EXP-PARTY';

        $maxDigits = ExpenseParty::where(function (Builder $receipt_query) {})->max('serial_number_digits');

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.$system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'].'/'.$system_data['serial_number_current_year'].'/'.'/'.$system_data['serial_number_digits'].'/'.$system_data['serial_number_suffix'];
        }

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createExpensePartySystemDTO = CreateExpensePartySystemDTO::validate($system_data);

        // Final Data Validation
        $createExpensePartyDTO = CreateExpensePartyDTO::validate(array_merge($createExpensePartyUserDTO, $createExpensePartySystemDTO));

        // Save In Database
        $expense_party = ExpenseParty::create($createExpensePartyDTO);

        return $expense_party;
    }
}
