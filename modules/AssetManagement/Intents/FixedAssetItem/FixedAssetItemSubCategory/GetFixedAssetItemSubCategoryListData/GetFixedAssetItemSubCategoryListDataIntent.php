<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\GetFixedAssetItemSubCategoryListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFixedAssetItemSubCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // FixedAssetItemSubCategory Data Validation
            $getFixedAssetItemSubCategoryListDataUserDTO = GetFixedAssetItemSubCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $FixedAssetItemSubCategoryListData = GetFixedAssetItemSubCategoryListDataAction::run($getFixedAssetItemSubCategoryListDataUserDTO, $actionData);
            $data['fixed_asset_item_sub_category_count'] = DB::table('fixed_asset_item_sub_category')->count();
            // After Intent

            // Return Response
            return array_merge($FixedAssetItemSubCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetFixedAssetItemSubCategoryListDataResDTO = GetFixedAssetItemSubCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetFixedAssetItemSubCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
