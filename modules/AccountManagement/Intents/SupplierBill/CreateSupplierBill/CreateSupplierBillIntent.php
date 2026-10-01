<?php

namespace Modules\AccountManagement\Intents\SupplierBill\CreateSupplierBill;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateSupplierBillIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $createSupplierBillUserDTO = CreateSupplierBillUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $actionData['supplier_bill_item_list'] = $request->supplier_bill_item_list;
            $actionData['supplier_bill_unsaved_attachment_list'] = $request->supplier_bill_unsaved_attachment_list;
            $supplierBill = CreateSupplierBillAction::run($createSupplierBillUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $supplierBill;
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
