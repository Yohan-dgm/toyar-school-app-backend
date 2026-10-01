<?php

namespace Modules\MaterialManagement\Intents\MaterialRequestNote\CreateMaterialRequestNote;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\MaterialManagement\Models\MaterialRequestNote;

class CreateMaterialRequestNoteAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        // User Data Validation
        $createMaterialRequestNoteUserDTO = CreateMaterialRequestNoteUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];
        $system_data['serial_number_prefix'] = 'NY/MRN';

        $maxDigits = MaterialRequestNote::where(function (Builder $receipt_query) {
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
        $createMaterialRequestNoteSystemDTO = CreateMaterialRequestNoteSystemDTO::validate($system_data);

        // Final Data Validation
        $createMaterialRequestNoteDTO = CreateMaterialRequestNoteDTO::validate(array_merge($createMaterialRequestNoteUserDTO, $createMaterialRequestNoteSystemDTO));

        // Save In Database
        $material_request_note = MaterialRequestNote::create($createMaterialRequestNoteDTO);

        // Attach material request notes with quantities
        if (isset($createMaterialRequestNoteUserDTO['material_item_list'])) {
            $material_request_notes = $createMaterialRequestNoteUserDTO['material_item_list'];

            // Check if it's a single item or an array of items
            if (! isset($material_request_notes[0])) {
                // Single item, convert to array
                $material_request_notes = [$material_request_notes];
            }

            foreach ($material_request_notes as $noteData) {
                $material_request_note->material_item_list()->attach(
                    $noteData['material_item_id'],
                    ['quantity' => $noteData['quantity']]
                );
            }
        }

        return $material_request_note;
    }
}
