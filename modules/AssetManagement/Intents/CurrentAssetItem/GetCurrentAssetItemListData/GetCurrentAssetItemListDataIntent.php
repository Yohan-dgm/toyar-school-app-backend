<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\GetCurrentAssetItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AssetManagement\Models\CurrentAssetItemType;

class GetCurrentAssetItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CurrentAssetItem Data Validation
            $getCurrentAssetItemListDataUserDTO = GetCurrentAssetItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $CurrentAssetItemListData = GetCurrentAssetItemListDataAction::run($getCurrentAssetItemListDataUserDTO, $actionData);
            $data['current_asset_item_count'] = DB::table('current_asset_item')->count();
            $data['current_asset_item_type_current_asset_item_count'] = CurrentAssetItemType::select('id', 'name')->withCount(['current_asset_item_list' => function (Builder $current_asset_item_type_list_query) {}])->orderBy('sequential_order', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($CurrentAssetItemListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetCurrentAssetItemListDataResDTO = GetCurrentAssetItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetCurrentAssetItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
