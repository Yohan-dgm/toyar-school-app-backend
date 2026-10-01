<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem;

use Modules\AccountManagement\Models\TermFeeInvoiceItem;

class CreateTermFeeInvoiceItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createTermFeeInvoiceItemUserDTO = CreateTermFeeInvoiceItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        $createTermFeeInvoiceItemSystemDTO = CreateTermFeeInvoiceItemSystemDTO::validate($system_data);
        $createTermFeeInvoiceItemDTO = CreateTermFeeInvoiceItemDTO::validate(array_merge($createTermFeeInvoiceItemUserDTO, $createTermFeeInvoiceItemSystemDTO));

        $termFeeInvoiceItem = TermFeeInvoiceItem::create($createTermFeeInvoiceItemDTO);

        return $termFeeInvoiceItem;
    }
}
