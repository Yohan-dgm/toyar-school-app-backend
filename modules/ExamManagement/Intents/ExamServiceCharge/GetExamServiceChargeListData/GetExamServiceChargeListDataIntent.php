<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\GetExamServiceChargeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamServiceChargeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamServiceChargeListDataUserDTO = GetExamServiceChargeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examServiceChargeListData = GetExamServiceChargeListDataAction::run($getExamServiceChargeListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_service_charge_count'] = DB::table('exam_service_charge')->count();
            // After Intent

            // Return Response
            return array_merge($examServiceChargeListData->toArray(), $data);
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
            $getExamServiceChargeListDataResDTO = GetExamServiceChargeListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamServiceChargeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
