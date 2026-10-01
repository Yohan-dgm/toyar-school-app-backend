<?php

namespace Modules\MaterialManagement\Intents\MaterialIssueNote\CreateMaterialIssueNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\MaterialManagement\Models\MaterialIssueNote;

class CreateMaterialIssueNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createMaterialIssueNoteUserDTO = CreateMaterialIssueNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        $system_data['serial_number_prefix'] = 'NY/MIN';

        $maxDigits = MaterialIssueNote::where(function (Builder $receipt_query) {
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

        // System Data Prep
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createMaterialIssueNoteSystemDTO = CreateMaterialIssueNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialIssueNoteDTO = CreateMaterialIssueNoteDTO::validate(array_merge($createMaterialIssueNoteUserDTO, $createMaterialIssueNoteSystemDTO));

        // Save In Database
        $purchaseOrderDTO = MaterialIssueNote::create($createMaterialIssueNoteDTO);

        return $purchaseOrderDTO;
    }
}
