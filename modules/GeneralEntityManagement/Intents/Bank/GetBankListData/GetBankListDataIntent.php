<?php

namespace Modules\GeneralEntityManagement\Intents\Bank\GetBankListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBankListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getBankListDataUserDTO = GetBankListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $BankListData = GetBankListDataAction::run($getBankListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["bank_count"] = DB::table("bank")->count();

            // After Intent

            // Return Response
            return array_merge($BankListData->toArray(), $data);
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
            $getBankListDataResDTO = GetBankListDataResDTO::validate($result);
            // Send Response
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $getBankListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
