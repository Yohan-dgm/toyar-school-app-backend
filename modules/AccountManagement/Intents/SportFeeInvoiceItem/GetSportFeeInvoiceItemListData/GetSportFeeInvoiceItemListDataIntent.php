<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoiceItem\GetSportFeeInvoiceItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSportFeeInvoiceItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // SportFeeInvoiceItem Data Validation
            $getSportFeeInvoiceItemListDataUserDTO = GetSportFeeInvoiceItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetSportFeeInvoiceItemListDataAction::run($getSportFeeInvoiceItemListDataUserDTO, $actionData);
            $data['sport_fee_invoice_item_count'] = DB::table('sport_fee_invoice_item')->count();

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
            $GetSportFeeInvoiceItemListDataResDTO = GetSportFeeInvoiceItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSportFeeInvoiceItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
