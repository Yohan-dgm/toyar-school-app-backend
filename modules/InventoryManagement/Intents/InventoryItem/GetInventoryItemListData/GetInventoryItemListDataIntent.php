<?php

namespace Modules\InventoryManagement\Intents\InventoryItem\GetInventoryItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetInventoryItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // InventoryItem Data Validation
            $getInventoryItemListDataUserDTO = GetInventoryItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $inventoryItemListData = GetInventoryItemListDataAction::run($getInventoryItemListDataUserDTO, $actionData);
            $data['inventory_item_count'] = DB::table('inventory_item')->count();
            // After Intent

            // Return Response
            return array_merge($inventoryItemListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetInventoryItemListDataResDTO = GetInventoryItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetInventoryItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
