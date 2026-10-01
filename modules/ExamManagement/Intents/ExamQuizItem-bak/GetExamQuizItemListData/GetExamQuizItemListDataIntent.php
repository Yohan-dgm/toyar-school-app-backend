<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\GetExamQuizItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamQuizItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamQuizItemListDataUserDTO = GetExamQuizItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examQuizItemListData = GetExamQuizItemListDataAction::run($getExamQuizItemListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_quiz_item_count'] = DB::table('exam_quiz_item')->count();
            // After Intent

            // Return Response
            return array_merge($examQuizItemListData->toArray(), $data);
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
            $getExamQuizItemListDataResDTO = GetExamQuizItemListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamQuizItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
