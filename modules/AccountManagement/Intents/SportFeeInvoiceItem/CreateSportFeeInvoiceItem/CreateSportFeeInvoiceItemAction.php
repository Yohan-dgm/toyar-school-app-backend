<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem;

use Modules\AccountManagement\Models\SportFeeInvoiceItem;

class CreateSportFeeInvoiceItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createSportFeeInvoiceItemUserDTO = CreateSportFeeInvoiceItemUserDTO::validate($payloadArray);

        // quary end
        // $createSportFeeInvoiceItemSystemDTO = CreateSportFeeInvoiceItemSystemDTO::validate($system_data);
        // $createSportFeeInvoiceItemDTO = CreateSportFeeInvoiceItemDTO::validate(array_merge($createSportFeeInvoiceItemUserDTO, $createSportFeeInvoiceItemSystemDTO));

        // $sportFeeInvoiceItem = SportFeeInvoiceItem::create($createSportFeeInvoiceItemDTO);
        $sportFeeInvoiceItem = SportFeeInvoiceItem::create($createSportFeeInvoiceItemUserDTO);

        return $sportFeeInvoiceItem;
    }
}
