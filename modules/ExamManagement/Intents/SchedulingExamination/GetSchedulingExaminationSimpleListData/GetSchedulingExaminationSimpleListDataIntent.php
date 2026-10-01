<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationSimpleListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSchedulingExaminationSimpleListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getSchedulingExaminationSimpleListDataUserDTO = GetSchedulingExaminationSimpleListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $schedulingExaminationSimpleListData = GetSchedulingExaminationSimpleListDataAction::run($getSchedulingExaminationSimpleListDataUserDTO, $actionData);

            // Action 2
            $data['scheduling_examinations_count'] = DB::table('scheduling_examination')->count();
            // After Intent

            // Return Response
            return array_merge($schedulingExaminationSimpleListData->toArray(), $data);
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
            $getSchedulingExaminationSimpleListDataResDTO = GetSchedulingExaminationSimpleListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getSchedulingExaminationSimpleListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
