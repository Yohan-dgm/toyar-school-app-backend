<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\GetCurrentAssetItemTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCurrentAssetItemTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CurrentAssetItemType Data Validation
            $getCurrentAssetItemTypeListDataUserDTO = GetCurrentAssetItemTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $currentAssetItemTypeListData = GetCurrentAssetItemTypeListDataAction::run($getCurrentAssetItemTypeListDataUserDTO, $actionData);
            $data['current_asset_item_type_count'] = DB::table('current_asset_item_type')->count();
            // After Intent

            // Return Response
            return array_merge($currentAssetItemTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetCurrentAssetItemTypeListDataResDTO = GetCurrentAssetItemTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetCurrentAssetItemTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
