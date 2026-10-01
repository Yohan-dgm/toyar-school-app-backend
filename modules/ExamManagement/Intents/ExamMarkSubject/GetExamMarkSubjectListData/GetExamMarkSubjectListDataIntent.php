<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\GetExamMarkSubjectListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamMarkSubjectListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamMarkSubjectListDataUserDTO = GetExamMarkSubjectListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examMarkSubjectListData = GetExamMarkSubjectListDataAction::run($getExamMarkSubjectListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_mark_subject_count'] = DB::table('scheduling_examination_grade_subject')->count();
            $data['pending_confirmation_count'] = DB::table('scheduling_examination_grade_subject')->where('is_all_marks_confirmed', false)->count();
            $data['confirmed_count'] = DB::table('scheduling_examination_grade_subject')->where('is_all_marks_confirmed', true)->count();
            // After Intent

            // Return Response
            return array_merge($examMarkSubjectListData->toArray(), $data);
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
            $getExamMarkSubjectListDataResDTO = GetExamMarkSubjectListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamMarkSubjectListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
