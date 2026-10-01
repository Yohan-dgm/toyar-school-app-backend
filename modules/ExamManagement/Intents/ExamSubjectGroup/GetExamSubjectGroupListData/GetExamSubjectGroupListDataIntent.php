<?php

namespace Modules\ExamManagement\Intents\ExamSubjectGroup\GetExamSubjectGroupListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamSubjectGroupListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamSubjectGroupListDataUserDTO = GetExamSubjectGroupListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examSubjectGroupListData = GetExamSubjectGroupListDataAction::run($getExamSubjectGroupListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_subject_group_count'] = DB::table('exam_subject_group')->count();

            // After Intent

            // Return Response
            return array_merge($examSubjectGroupListData->toArray(), $data);
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
            $getExamSubjectGroupListDataResDTO = GetExamSubjectGroupListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamSubjectGroupListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
