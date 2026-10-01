<?php

namespace Modules\PurchasingManagement\Intents\Supplier\UpdateSupplier;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\GeneralEntityManagement\Models\PersonTitle;
use Modules\PurchasingManagement\Models\Supplier;

class UpdateSupplierAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateSupplierUserDTO = UpdateSupplierUserDTO::validate($payloadArray);

        // Data Prep
        $system_data = [];

        // System Data Prep
        $system_data['updated_by'] = $actionData['updated_by'];

        if ($updateSupplierUserDTO['supplier_type'] == 'Person') {
            $personTitle = PersonTitle::find($updateSupplierUserDTO['person_title_id']);
            $system_data['name_with_title'] = $personTitle->name.' '.$updateSupplierUserDTO['name'];
        } elseif ($updateSupplierUserDTO['supplier_type'] == 'Organization') {
            $updateSupplierUserDTO['person_title_id'] = null;
            $system_data['name_with_title'] = 'M/s. '.$updateSupplierUserDTO['name'];
        }

        if ($updateSupplierUserDTO['email'] == null) {
            $system_data['email'] = null;
        }

        // System Data Validation
        $updateSupplierSystemDTO = UpdateSupplierSystemDTO::validate($system_data);

        // Final Data Validation
        $updateSupplierDTO = UpdateSupplierDTO::validate(array_merge($updateSupplierUserDTO, $updateSupplierSystemDTO));

        // Save In Database
        Supplier::where('id', $updateSupplierUserDTO['id'])->update($updateSupplierDTO);
        $updatedSupplier = Supplier::find($updateSupplierUserDTO['id']);

        return $updatedSupplier;
    }
}
