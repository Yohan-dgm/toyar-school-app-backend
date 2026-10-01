<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\GetApplicantProformaInvoiceItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetApplicantProformaInvoiceItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ApplicantProformaInvoiceItem Data Validation
            $getApplicantProformaInvoiceItemListDataUserDTO = GetApplicantProformaInvoiceItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetApplicantProformaInvoiceItemListDataAction::run($getApplicantProformaInvoiceItemListDataUserDTO, $actionData);
            $data['applicant_proforma_invoice_item_count'] = DB::table('applicant_proforma_invoice_item')->count();

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
            $GetApplicantProformaInvoiceItemListDataResDTO = GetApplicantProformaInvoiceItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetApplicantProformaInvoiceItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
