<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem;

use Modules\AccountManagement\Models\AdmissionFeeInvoiceItem;

class CreateAdmissionFeeInvoiceItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createAdmissionFeeInvoiceItemUserDTO = CreateAdmissionFeeInvoiceItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['billed_quantity'] = 0;
        $system_data['issued_quantity'] = 0;

        $createAdmissionFeeInvoiceItemSystemDTO = CreateAdmissionFeeInvoiceItemSystemDTO::validate($system_data);
        $createAdmissionFeeInvoiceItemDTO = CreateAdmissionFeeInvoiceItemDTO::validate(array_merge($createAdmissionFeeInvoiceItemUserDTO, $createAdmissionFeeInvoiceItemSystemDTO));

        $admissionFeeInvoiceItem = AdmissionFeeInvoiceItem::create($createAdmissionFeeInvoiceItemDTO);

        return $admissionFeeInvoiceItem;
    }
}
