<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\GetIncomeCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeType;

class GetIncomeCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // IncomeCategory Data Validation
            $getIncomeCategoryListDataUserDTO = GetIncomeCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $IncomeCategoryListData = GetIncomeCategoryListDataAction::run($getIncomeCategoryListDataUserDTO, $actionData);
            $data['income_category_count'] = DB::table('income_category')->count();
            $data['income_type_category_list_count'] = IncomeType::select('id', 'name')->withCount(['income_category_list' => function (Builder $income_category_list_query) {}])->orderBy('sequential_order', 'asc')->get();

            // After Intent

            // Return Response
            return array_merge($IncomeCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetIncomeCategoryListDataResDTO = GetIncomeCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetIncomeCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
