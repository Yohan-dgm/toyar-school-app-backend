<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportBySchedulingExaminationId;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentExamReportBySchedulingExaminationIdIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentExamReport Data Validation
            $getStudentExamReportBySchedulingExaminationIdUserDTO = GetStudentExamReportBySchedulingExaminationIdUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $studentExamReportData = GetStudentExamReportBySchedulingExaminationIdAction::run($getStudentExamReportBySchedulingExaminationIdUserDTO, $actionData);

            // After Intent

            // Return Response
            return $studentExamReportData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentExamReportBySchedulingExaminationIdResDTO = GetStudentExamReportBySchedulingExaminationIdResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => 'Student exam reports retrieved successfully',
                    'data' => $GetStudentExamReportBySchedulingExaminationIdResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
