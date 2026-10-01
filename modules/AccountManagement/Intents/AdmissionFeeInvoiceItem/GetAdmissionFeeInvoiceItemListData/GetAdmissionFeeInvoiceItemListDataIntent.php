<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\GetAdmissionFeeInvoiceItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAdmissionFeeInvoiceItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // AdmissionFeeInvoiceItem Data Validation
            $getAdmissionFeeInvoiceItemListDataUserDTO = GetAdmissionFeeInvoiceItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetAdmissionFeeInvoiceItemListDataAction::run($getAdmissionFeeInvoiceItemListDataUserDTO, $actionData);
            $data['admission_fee_invoice_item_count'] = DB::table('admission_fee_invoice_item')->count();

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
            $GetAdmissionFeeInvoiceItemListDataResDTO = GetAdmissionFeeInvoiceItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetAdmissionFeeInvoiceItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
