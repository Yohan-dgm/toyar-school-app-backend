<?php

namespace Modules\AccountManagement\Intents\SupplierBill\GetSupplierBillListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSupplierBillListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // SupplierBill Data Validation
            $getSupplierBillListDataUserDTO = GetSupplierBillListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetSupplierBillListDataAction::run($getSupplierBillListDataUserDTO, $actionData);
            $data['supplier_bill_count'] = DB::table('supplier_bill')->count();

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
            $GetSupplierBillListDataResDTO = GetSupplierBillListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSupplierBillListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
