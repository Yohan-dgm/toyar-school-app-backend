<?php

namespace Modules\AccountManagement\Intents\RefundableDepositItem\GetRefundableDepositItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRefundableDepositItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // RefundableDepositItem Data Validation
            $getRefundableDepositItemListDataUserDTO = GetRefundableDepositItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetRefundableDepositItemListDataAction::run($getRefundableDepositItemListDataUserDTO, $actionData);
            $data['refundable_deposit_item_count'] = DB::table('refundable_deposit_item')->count();

            // After Intent

            // Return Response
            return array_merge($gradeLevelList->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetRefundableDepositItemListDataResDTO = GetRefundableDepositItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetRefundableDepositItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
