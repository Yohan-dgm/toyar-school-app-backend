<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\GetAdmissionFeeInvoiceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAdmissionFeeInvoiceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // AdmissionFeeInvoice Data Validation
            $getAdmissionFeeInvoiceListDataUserDTO = GetAdmissionFeeInvoiceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $gradeLevelList = GetAdmissionFeeInvoiceListDataAction::run($getAdmissionFeeInvoiceListDataUserDTO, $actionData);
            $data['admission_fee_invoice_count'] = DB::table('admission_fee_invoice')->count();

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
            $GetAdmissionFeeInvoiceListDataResDTO = GetAdmissionFeeInvoiceListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetAdmissionFeeInvoiceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
