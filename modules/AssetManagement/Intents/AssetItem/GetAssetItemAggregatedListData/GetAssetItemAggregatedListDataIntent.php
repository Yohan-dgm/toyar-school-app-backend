<?php

namespace Modules\AssetManagement\Intents\AssetItem\GetAssetItemAggregatedListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAssetItemAggregatedListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // AssetItem Data Validation
            $getAssetItemListDataUserDTO = GetAssetItemAggregatedListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetAssetItemAggregatedListDataAction::run($getAssetItemListDataUserDTO, $actionData);
            $data['asset_item_count'] = DB::table('asset_item')->count();
            // After Intent

            // Return Response
            return array_merge($gradeLevelList->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetAssetItemAggregatedListDataResDTO = GetAssetItemAggregatedListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetAssetItemAggregatedListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
