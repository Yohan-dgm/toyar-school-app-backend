<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\GetTermFeeInvoiceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\TermFeeInvoice;

class GetTermFeeInvoiceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // TermFeeInvoice Data Validation
            $getTermFeeInvoiceListDataUserDTO = GetTermFeeInvoiceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $gradeLevelList = GetTermFeeInvoiceListDataAction::run($getTermFeeInvoiceListDataUserDTO, $actionData);
            $data['term_fee_invoice_count'] = DB::table('term_fee_invoice')->count();

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
            $GetTermFeeInvoiceListDataResDTO = GetTermFeeInvoiceListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetTermFeeInvoiceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
