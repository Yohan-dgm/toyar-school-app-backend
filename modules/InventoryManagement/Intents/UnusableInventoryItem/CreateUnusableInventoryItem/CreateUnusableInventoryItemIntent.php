<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUnusableInventoryItemIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createUnusableInventoryItemUserDTO = CreateUnusableInventoryItemUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $actionData['unusable_marked_by'] = $request->user()->id;
            $actionData['unusable_marked_date'] = date('Y-m-d');
            $actionData['unusable_inventory_item_status_type_id'] = 1;

            $Unusableinventoryitem = CreateUnusableInventoryItemAction::run($createUnusableInventoryItemUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $Unusableinventoryitem;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => '',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => '',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
