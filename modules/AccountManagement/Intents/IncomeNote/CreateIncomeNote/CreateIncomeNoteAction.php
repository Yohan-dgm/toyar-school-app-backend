<?php

namespace Modules\AccountManagement\Intents\IncomeNote\CreateIncomeNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeNote;

class CreateIncomeNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createIncomeNoteUserDTO = CreateIncomeNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['serial_number_prefix'] = 'NY/INC-NOTE';
        $maxDigits = IncomeNote::where(function (Builder $receipt_query) {
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

        // System Data Validation
        $createIncomeNoteSystemDTO = CreateIncomeNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $createIncomeNoteDTO = CreateIncomeNoteDTO::validate(array_merge($createIncomeNoteUserDTO, $createIncomeNoteSystemDTO));

        // Save In Database
        $createIncomeNote = IncomeNote::create($createIncomeNoteDTO);

        return $createIncomeNote;
    }
}
