<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\GetFixedAssetItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemType;

class GetFixedAssetItemCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // FixedAssetItemCategory Data Validation
            $getFixedAssetItemCategoryListDataUserDTO = GetFixedAssetItemCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $FixedAssetItemCategoryListData = GetFixedAssetItemCategoryListDataAction::run($getFixedAssetItemCategoryListDataUserDTO, $actionData);
            $data['fixed_asset_item_category_count'] = DB::table('fixed_asset_item_category')->count();
            $data['fixed_asset_item_type_category_list_count'] = FixedAssetItemType::select('id', 'name')->withCount(['fixed_asset_item_category_list' => function (Builder $fixed_asset_item_category_list_query) {}])->orderBy('sequential_order', 'asc')->get();

            // After Intent

            // Return Response
            return array_merge($FixedAssetItemCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetFixedAssetItemCategoryListDataResDTO = GetFixedAssetItemCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetFixedAssetItemCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
