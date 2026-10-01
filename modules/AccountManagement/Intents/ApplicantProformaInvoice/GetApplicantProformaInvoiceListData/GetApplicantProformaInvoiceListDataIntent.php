<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\GetApplicantProformaInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ApplicantProformaInvoice;
use Modules\AccountManagement\Models\ReceiptVoucher;

class GetApplicantProformaInvoiceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ApplicantProformaInvoice Data Validation
            $getApplicantProformaInvoiceListDataUserDTO = GetApplicantProformaInvoiceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetApplicantProformaInvoiceListDataAction::run($getApplicantProformaInvoiceListDataUserDTO, $actionData);
            $data['applicant_proforma_invoice_count'] = DB::table('applicant_proforma_invoice')->count();
            $data['payment_completed_invoices_count'] = ApplicantProformaInvoice::select('id')
                ->where('is_applicant_proforma_invoice_complete', true)
                // ->whereNot('bill_total', 0)
                ->count();

            $data['due_payment_invoices_count'] = ApplicantProformaInvoice::select('id')
                ->where('is_applicant_proforma_invoice_complete', false)
                // ->whereNot('bill_total', 0)
                ->count();
            $data['payment_due_invoice_total_amount'] =
                ApplicantProformaInvoice::where('bill_total', '>', 0)->where('is_applicant_proforma_invoice_complete', false)->sum('bill_total')
                -
                ReceiptVoucher::where('is_active', true)->where('applicant_id', '!=', null)->whereHas('applicant_proforma_invoice', function ($applicant_proforma_invoice_query) {
                    $applicant_proforma_invoice_query->where(function (Builder $applicant_proforma_invoice_group1) {
                        $applicant_proforma_invoice_group1->where('is_applicant_proforma_invoice_complete', false);
                        // $applicant_proforma_invoice_group1->whereNot('bill_total', 0);
                    });
                })->sum('amount');

            $data['invoice_total_amount'] = ApplicantProformaInvoice::sum('bill_total');
            $data['total_invoice_count'] = ApplicantProformaInvoice::count();

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
            $GetApplicantProformaInvoiceListDataResDTO = GetApplicantProformaInvoiceListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetApplicantProformaInvoiceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
