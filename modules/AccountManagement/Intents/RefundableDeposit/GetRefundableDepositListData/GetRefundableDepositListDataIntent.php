<?php

namespace Modules\AccountManagement\Intents\RefundableDeposit\GetRefundableDepositListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\RefundableDeposit;

class GetRefundableDepositListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // RefundableDeposit Data Validation
            $getRefundableDepositListDataUserDTO = GetRefundableDepositListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $gradeLevelList = GetRefundableDepositListDataAction::run($getRefundableDepositListDataUserDTO, $actionData);
            $data['refundable_deposit_count'] = DB::table('refundable_deposit')->count();

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
            $GetRefundableDepositListDataResDTO = GetRefundableDepositListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetRefundableDepositListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
