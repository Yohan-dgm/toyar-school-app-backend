<?php

namespace Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem;

use Modules\AccountManagement\Models\CashDepositItem;

class CreateCashDepositItemAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createCashDepositItemUserDTO = CreateCashDepositItemUserDTO::validate($payloadArray);

        $system_data = [
            'created_by' => $actionData['created_by'],
        ];

        $createCashDepositItemSystemDTO = CreateCashDepositItemSystemDTO::validate($system_data);
        $createCashDepositItemDTO = CreateCashDepositItemDTO::validate(array_merge($createCashDepositItemUserDTO, $createCashDepositItemSystemDTO));

        $createCashDepositItem = CashDepositItem::create($createCashDepositItemDTO);

        return $createCashDepositItem;
    }
}
