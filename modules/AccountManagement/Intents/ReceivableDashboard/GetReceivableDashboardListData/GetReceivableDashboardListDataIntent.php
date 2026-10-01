<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\GetReceivableDashboardListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReceivableDashboardListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // AdmissionFeeInvoice Data Validation
            $getReceivableDashboardListDataUserDTO = GetReceivableDashboardListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $dashboardListData = GetReceivableDashboardListDataAction::run($getReceivableDashboardListDataUserDTO, $actionData);
            // $data["admission_fee_invoice_count"] = DB::table("admission_fee_invoice")->count();

            // After Intent

            // Return Response
            return array_merge($dashboardListData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            // Get Intent Result
            $result = $this->handle($request);
            // Response Data Validation
            $getReceivableDashboardListDataResDTO = GetReceivableDashboardListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getReceivableDashboardListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
