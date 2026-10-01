<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\GetCurrentAssetItemCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemType;

class GetCurrentAssetItemCategoryListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CurrentAssetItemCategory Data Validation
            $getCurrentAssetItemCategoryListDataUserDTO = GetCurrentAssetItemCategoryListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $CurrentAssetItemCategoryListData = GetCurrentAssetItemCategoryListDataAction::run($getCurrentAssetItemCategoryListDataUserDTO, $actionData);
            $data['current_asset_item_category_count'] = DB::table('current_asset_item_category')->count();
            $data['current_asset_item_type_category_list_count'] = CurrentAssetItemType::select('id', 'name')->withCount(['current_asset_item_category_list' => function (Builder $current_asset_item_category_list_query) {}])->orderBy('sequential_order', 'asc')->get();

            // After Intent

            // Return Response
            return array_merge($CurrentAssetItemCategoryListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetCurrentAssetItemCategoryListDataResDTO = GetCurrentAssetItemCategoryListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetCurrentAssetItemCategoryListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
