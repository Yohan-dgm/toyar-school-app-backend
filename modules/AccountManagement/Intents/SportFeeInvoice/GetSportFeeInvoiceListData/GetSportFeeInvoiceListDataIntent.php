<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\GetSportFeeInvoiceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SportFeeInvoice;

class GetSportFeeInvoiceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // SportFeeInvoice Data Validation
            $getSportFeeInvoiceListDataUserDTO = GetSportFeeInvoiceListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $gradeLevelList = GetSportFeeInvoiceListDataAction::run($getSportFeeInvoiceListDataUserDTO, $actionData);
            $data['sport_fee_invoice_count'] = DB::table('sport_fee_invoice')->count();

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
            $GetSportFeeInvoiceListDataResDTO = GetSportFeeInvoiceListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSportFeeInvoiceListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
