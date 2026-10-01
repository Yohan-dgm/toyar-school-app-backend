<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\GetFixedAssetItemTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFixedAssetItemTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // FixedAssetItemType Data Validation
            $getFixedAssetItemTypeListDataUserDTO = GetFixedAssetItemTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $fixedAssetItemTypeListData = GetFixedAssetItemTypeListDataAction::run($getFixedAssetItemTypeListDataUserDTO, $actionData);
            $data['fixed_asset_item_type_count'] = DB::table('fixed_asset_item_type')->count();
            // After Intent

            // Return Response
            return array_merge($fixedAssetItemTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetFixedAssetItemTypeListDataResDTO = GetFixedAssetItemTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetFixedAssetItemTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
