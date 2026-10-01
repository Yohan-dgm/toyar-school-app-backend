<?php

namespace Modules\AccountManagement\Intents\ExpenseType\GetExpenseTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExpenseTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ExpenseType Data Validation
            $getExpenseTypeListDataUserDTO = GetExpenseTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $expenseTypeListData = GetExpenseTypeListDataAction::run($getExpenseTypeListDataUserDTO, $actionData);
            $data['expense_type_count'] = DB::table('expense_type')->count();
            // After Intent

            // Return Response
            return array_merge($expenseTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetExpenseTypeListDataResDTO = GetExpenseTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetExpenseTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
