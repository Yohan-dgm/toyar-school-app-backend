<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\GetSchedulingExaminationGradeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSchedulingExaminationGradeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getSchedulingExaminationGradeListDataUserDTO = GetSchedulingExaminationGradeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $schedulingExaminationGradeListData = GetSchedulingExaminationGradeListDataAction::run($getSchedulingExaminationGradeListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['scheduling_examination_grades_count'] = DB::table('scheduling_examination_grade')->count();
            // After Intent

            // Return Response
            return array_merge($schedulingExaminationGradeListData->toArray(), $data);
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
            $getSchedulingExaminationGradeListDataResDTO = GetSchedulingExaminationGradeListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getSchedulingExaminationGradeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
