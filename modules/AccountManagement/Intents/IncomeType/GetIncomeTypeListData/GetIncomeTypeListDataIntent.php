<?php

namespace Modules\AccountManagement\Intents\IncomeType\GetIncomeTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetIncomeTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // IncomeType Data Validation
            $getIncomeTypeListDataUserDTO = GetIncomeTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $incomeTypeListData = GetIncomeTypeListDataAction::run($getIncomeTypeListDataUserDTO, $actionData);
            $data['income_type_count'] = DB::table('income_type')->count();
            // After Intent

            // Return Response
            return array_merge($incomeTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetIncomeTypeListDataResDTO = GetIncomeTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetIncomeTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
