<?php

namespace Modules\InventoryManagement\Intents\MaterialItemSubCategory\GetMaterialItemSubCategoryListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMaterialItemSubCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // MaterialItemSubCategory Data Validation
            $getMaterialItemSubCategoryListDataUserDTO = GetMaterialItemSubCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $MaterialItemSubCategoryListData = GetMaterialItemSubCategoryListDataAction::run($getMaterialItemSubCategoryListDataUserDTO, $actionData);
            $data['material_item_sub_category_count'] = DB::table('material_item_sub_category')->count();
            // After Intent

            // Return Response
            return array_merge($MaterialItemSubCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetMaterialItemSubCategoryListDataResDTO = GetMaterialItemSubCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetMaterialItemSubCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
