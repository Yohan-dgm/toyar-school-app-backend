<?php

namespace Modules\AccountManagement\Intents\PayableAccount\GetPayableAccountListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPayableAccountListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getPayableAccountListDataUserDTO = GetPayableAccountListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $payableAccountListData = GetPayableAccountListDataAction::run($getPayableAccountListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['payable_account_count'] = DB::table('payable_account')->count();

            // After Intent

            // Return Response
            return array_merge($payableAccountListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            // Get Intent Result
            $result = $this->handle($request);
            // Response Data Validation
            $getPayableAccountListDataResDTO = GetPayableAccountListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getPayableAccountListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
