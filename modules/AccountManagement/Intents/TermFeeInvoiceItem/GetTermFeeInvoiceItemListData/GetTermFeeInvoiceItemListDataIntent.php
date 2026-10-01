<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\GetTermFeeInvoiceItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTermFeeInvoiceItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // TermFeeInvoiceItem Data Validation
            $getTermFeeInvoiceItemListDataUserDTO = GetTermFeeInvoiceItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetTermFeeInvoiceItemListDataAction::run($getTermFeeInvoiceItemListDataUserDTO, $actionData);
            $data['term_fee_invoice_item_count'] = DB::table('term_fee_invoice_item')->count();

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
            $GetTermFeeInvoiceItemListDataResDTO = GetTermFeeInvoiceItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetTermFeeInvoiceItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
