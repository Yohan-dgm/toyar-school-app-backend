<?php

namespace Modules\PurchasingManagement\Intents\Supplier\CreateSupplier;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\PersonTitle;
use Modules\PurchasingManagement\Models\Supplier;

class CreateSupplierAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        // User Data Validation
        $createSupplierUserDTO = CreateSupplierUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        if ($createSupplierUserDTO['supplier_type'] == 'Organization') {
            $system_data['name_with_title'] = 'M/s. '.$createSupplierUserDTO['name'];
        } else {
            $personTitle = PersonTitle::find($createSupplierUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$createSupplierUserDTO['name'];
        }

        $system_data['serial_number_prefix'] = 'NEXIS/SUP';

        $maxDigits = Supplier::where(function (Builder $receipt_query) {})->max('serial_number_digits');

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
        $createSupplierSystemDTO = CreateSupplierSystemDTO::validate($system_data);

        // Final Data Validation
        $createSupplierDTO = CreateSupplierDTO::validate(array_merge($createSupplierUserDTO, $createSupplierSystemDTO));

        // Save In Database
        $supplier = Supplier::create($createSupplierDTO);

        return $supplier;
    }
}
