<?php

namespace Modules\InventoryManagement\Intents\MaterialItemType\GetMaterialItemTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMaterialItemTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // MaterialItemType Data Validation
            $getMaterialItemTypeListDataUserDTO = GetMaterialItemTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $materialItemTypeListData = GetMaterialItemTypeListDataAction::run($getMaterialItemTypeListDataUserDTO, $actionData);
            $data['material_item_type_count'] = DB::table('material_item_type')->count();
            // After Intent

            // Return Response
            return array_merge($materialItemTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetMaterialItemTypeListDataResDTO = GetMaterialItemTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetMaterialItemTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
