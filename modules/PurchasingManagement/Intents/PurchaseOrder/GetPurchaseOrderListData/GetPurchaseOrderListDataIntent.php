<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\GetPurchaseOrderListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\PaymentVoucher;
use Modules\AccountManagement\Models\SupplierBill;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class GetPurchaseOrderListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // PurchaseOrder Data Validation
            $getPurchaseOrderListDataUserDTO = GetPurchaseOrderListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetPurchaseOrderListDataAction::run($getPurchaseOrderListDataUserDTO, $actionData);
            $data['purchase_order_count'] = DB::table('purchase_order')->count();
            $data['due_payment_order_count'] = PurchaseOrder::where('is_purchase_order_complete', false)->count();

            $data['payment_completed_order_count'] = PurchaseOrder::where('is_purchase_order_complete', true)->count();

            $data['payment_due_invoice_total_amount'] = SupplierBill::whereHas('purchase_order')->sum('bill_total')
                -
                PaymentVoucher::whereHas('purchase_order')->sum('amount');

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
            $GetPurchaseOrderListDataResDTO = GetPurchaseOrderListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetPurchaseOrderListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
