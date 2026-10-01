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

            // ReceivableDashboard Data Validation
            $getReceivableDashboardListDataUserDTO = GetReceivableDashboardListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $receivable_dashboardListData = GetReceivableDashboardListDataAction::run($getReceivableDashboardListDataUserDTO, $actionData);
            $data['receivable_dashboard_count'] = DB::table('admission_fee_invoice')->count();

            // After Intent

            // Return Response
            return array_merge($receivable_dashboardListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetReceivableDashboardListDataResDTO = GetReceivableDashboardListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetReceivableDashboardListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
