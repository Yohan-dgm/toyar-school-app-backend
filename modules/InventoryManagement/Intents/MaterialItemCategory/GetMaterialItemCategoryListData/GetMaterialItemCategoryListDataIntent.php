<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\GetMaterialItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemType;

class GetMaterialItemCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // MaterialItemCategory Data Validation
            $getMaterialItemCategoryListDataUserDTO = GetMaterialItemCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $MaterialItemCategoryListData = GetMaterialItemCategoryListDataAction::run($getMaterialItemCategoryListDataUserDTO, $actionData);
            $data['material_item_category_count'] = DB::table('material_item_category')->count();
            $data['material_item_type_category_list_count'] = MaterialItemType::select('id', 'name')->withCount(['material_item_category_list' => function (Builder $material_item_category_list_query) {}])->orderBy('sequential_order', 'asc')->get();

            // After Intent

            // Return Response
            return array_merge($MaterialItemCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetMaterialItemCategoryListDataResDTO = GetMaterialItemCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetMaterialItemCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
