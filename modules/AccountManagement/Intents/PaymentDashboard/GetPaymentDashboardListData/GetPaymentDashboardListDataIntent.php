<?php

namespace Modules\AccountManagement\Intents\PaymentDashboard\GetPaymentDashboardListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPaymentDashboardListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // AdmissionFeeInvoice Data Validation
            $getPaymentDashboardListDataUserDTO = GetPaymentDashboardListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $dashboardListData = GetPaymentDashboardListDataAction::run($getPaymentDashboardListDataUserDTO, $actionData);
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
            $getPaymentDashboardListDataResDTO = GetPaymentDashboardListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getPaymentDashboardListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
