<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\GetMaterialBillItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMaterialBillItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // MaterialBillItem Data Validation
            $getMaterialBillItemListDataUserDTO = GetMaterialBillItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetMaterialBillItemListDataAction::run($getMaterialBillItemListDataUserDTO, $actionData);
            $data['material_bill_item_count'] = DB::table('material_bill_item')->count();

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
            $GetMaterialBillItemListDataResDTO = GetMaterialBillItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetMaterialBillItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
