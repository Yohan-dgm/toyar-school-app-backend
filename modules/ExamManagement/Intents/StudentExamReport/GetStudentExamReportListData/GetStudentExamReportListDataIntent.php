<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevelClass;

class GetStudentExamReportListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentExamReport Data Validation
            $getStudentExamReportListDataUserDTO = GetStudentExamReportListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $studentExamReportListData = GetStudentExamReportListDataAction::run($getStudentExamReportListDataUserDTO, $actionData);
            $data['student_exam_report_count'] = DB::table('student_exam_report')->count();
            $data['grade_level_class_student_count'] = GradeLevelClass::select('id', 'name')->withCount(['student_exam_report_list'])->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($studentExamReportListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentExamReportListDataResDTO = GetStudentExamReportListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentExamReportListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
