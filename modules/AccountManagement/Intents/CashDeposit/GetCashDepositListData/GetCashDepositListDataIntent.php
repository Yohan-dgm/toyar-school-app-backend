<?php

namespace Modules\AccountManagement\Intents\CashDeposit\GetCashDepositListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCashDepositListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CashDeposit Data Validation
            $getCashDepositListDataUserDTO = GetCashDepositListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetCashDepositListDataAction::run($getCashDepositListDataUserDTO, $actionData);
            $data['cash_deposit_count'] = DB::table('cash_deposit')->count();
            $data['pending_attachment_count'] = DB::table('cash_deposit')->where('is_attached', false)->count();

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
            $GetCashDepositListDataResDTO = GetCashDepositListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetCashDepositListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
