<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponentType\GetExamSubjectComponentTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamSubjectComponentTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamSubjectComponentTypeListDataUserDTO = GetExamSubjectComponentTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examSubjectComponentTypeListData = GetExamSubjectComponentTypeListDataAction::run($getExamSubjectComponentTypeListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_subject_component_type_count'] = DB::table('exam_subject_component_type')->count();

            // After Intent

            // Return Response
            return array_merge($examSubjectComponentTypeListData->toArray(), $data);
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
            $getExamSubjectComponentTypeListDataResDTO = GetExamSubjectComponentTypeListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamSubjectComponentTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
