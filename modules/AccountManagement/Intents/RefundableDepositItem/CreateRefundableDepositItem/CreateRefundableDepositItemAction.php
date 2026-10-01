<?php

namespace Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem;

use Modules\AccountManagement\Models\RefundableDepositItem;

class CreateRefundableDepositItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createRefundableDepositItemUserDTO = CreateRefundableDepositItemUserDTO::validate($payloadArray);

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];
        $system_data['billed_quantity'] = 0;
        $system_data['issued_quantity'] = 0;

        $createRefundableDepositItemSystemDTO = CreateRefundableDepositItemSystemDTO::validate($system_data);
        $createRefundableDepositItemDTO = CreateRefundableDepositItemDTO::validate(array_merge($createRefundableDepositItemUserDTO, $createRefundableDepositItemSystemDTO));

        $refundableDepositItem = RefundableDepositItem::create($createRefundableDepositItemDTO);

        return $refundableDepositItem;
    }
}
