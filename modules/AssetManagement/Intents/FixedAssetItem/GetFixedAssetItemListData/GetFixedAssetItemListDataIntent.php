<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\GetFixedAssetItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\FixedAssetItemType;

class GetFixedAssetItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // FixedAssetItem Data Validation
            $getFixedAssetItemListDataUserDTO = GetFixedAssetItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $FixedAssetItemListData = GetFixedAssetItemListDataAction::run($getFixedAssetItemListDataUserDTO, $actionData);
            $data['fixed_asset_item_count'] = DB::table('fixed_asset_item')->count();
            $data['fixed_asset_item_type_fixed_asset_item_count'] = FixedAssetItemType::select('id', 'name')->withCount(['fixed_asset_item_list' => function (Builder $fixed_asset_item_type_list_query) {}])->orderBy('sequential_order', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($FixedAssetItemListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetFixedAssetItemListDataResDTO = GetFixedAssetItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetFixedAssetItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
