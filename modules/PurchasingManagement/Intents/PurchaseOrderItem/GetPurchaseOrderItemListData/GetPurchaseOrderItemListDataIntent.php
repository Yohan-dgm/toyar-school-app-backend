<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\GetPurchaseOrderItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPurchaseOrderItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // PurchaseOrderItem Data Validation
            $getPurchaseOrderItemListDataUserDTO = GetPurchaseOrderItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetPurchaseOrderItemListDataAction::run($getPurchaseOrderItemListDataUserDTO, $actionData);
            $data['purchase_order_item_count'] = DB::table('purchase_order_item')->count();

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
            $GetPurchaseOrderItemListDataResDTO = GetPurchaseOrderItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetPurchaseOrderItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
