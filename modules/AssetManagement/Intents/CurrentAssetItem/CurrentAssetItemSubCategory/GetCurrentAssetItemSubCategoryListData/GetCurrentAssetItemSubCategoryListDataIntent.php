<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\GetCurrentAssetItemSubCategoryListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCurrentAssetItemSubCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CurrentAssetItemSubCategory Data Validation
            $getCurrentAssetItemSubCategoryListDataUserDTO = GetCurrentAssetItemSubCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $CurrentAssetItemSubCategoryListData = GetCurrentAssetItemSubCategoryListDataAction::run($getCurrentAssetItemSubCategoryListDataUserDTO, $actionData);
            $data['current_asset_item_sub_category_count'] = DB::table('current_asset_item_sub_category')->count();
            // After Intent

            // Return Response
            return array_merge($CurrentAssetItemSubCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetCurrentAssetItemSubCategoryListDataResDTO = GetCurrentAssetItemSubCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetCurrentAssetItemSubCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
