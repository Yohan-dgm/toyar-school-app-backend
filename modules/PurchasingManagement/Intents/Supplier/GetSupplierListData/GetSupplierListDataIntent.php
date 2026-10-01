<?php

namespace Modules\PurchasingManagement\Intents\Supplier\GetSupplierListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSupplierListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Supplier Data Validation
            $getSupplierListDataUserDTO = GetSupplierListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $supplierListData = GetSupplierListDataAction::run($getSupplierListDataUserDTO, $actionData);
            $data['supplier_count'] = DB::table('supplier')->count();

            // After Intent

            // Return Response
            return array_merge($supplierListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetSupplierListDataResDTO = GetSupplierListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSupplierListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
