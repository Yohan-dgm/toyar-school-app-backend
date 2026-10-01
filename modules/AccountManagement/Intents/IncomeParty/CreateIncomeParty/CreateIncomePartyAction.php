<?php

namespace Modules\AccountManagement\Intents\IncomeParty\CreateIncomeParty;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeParty;
use Modules\GeneralEntityManagement\Models\PersonTitle;

class CreateIncomePartyAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        // User Data Validation
        $createIncomePartyUserDTO = CreateIncomePartyUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        if ($createIncomePartyUserDTO['income_party_type'] == 'Organization') {
            $system_data['name_with_title'] = 'M/s. '.$createIncomePartyUserDTO['name'];
        } else {
            $personTitle = PersonTitle::find($createIncomePartyUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$createIncomePartyUserDTO['name'];
        }

        $system_data['serial_number_prefix'] = 'NEXIS/EXP-PARTY';

        $maxDigits = IncomeParty::where(function (Builder $receipt_query) {})->max('serial_number_digits');

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
        $createIncomePartySystemDTO = CreateIncomePartySystemDTO::validate($system_data);

        // Final Data Validation
        $createIncomePartyDTO = CreateIncomePartyDTO::validate(array_merge($createIncomePartyUserDTO, $createIncomePartySystemDTO));

        // Save In Database
        $income_party = IncomeParty::create($createIncomePartyDTO);

        return $income_party;
    }
}
