<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\GetExpenseCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseType;

class GetExpenseCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ExpenseCategory Data Validation
            $getExpenseCategoryListDataUserDTO = GetExpenseCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $ExpenseCategoryListData = GetExpenseCategoryListDataAction::run($getExpenseCategoryListDataUserDTO, $actionData);
            $data['expense_category_count'] = DB::table('expense_category')->count();
            $data['expense_type_category_list_count'] = ExpenseType::select('id', 'name')->withCount(['expense_category_list' => function (Builder $expense_category_list_query) {}])->orderBy('sequential_order', 'asc')->get();

            // After Intent

            // Return Response
            return array_merge($ExpenseCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetExpenseCategoryListDataResDTO = GetExpenseCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetExpenseCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
