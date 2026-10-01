<?php

namespace Modules\ExamManagement\Intents\StudentExamData\GetStudentExamData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetStudentExamDataIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $payloadArray = $request->all();
            $actionData = [];

            $result = GetStudentExamDataAction::run($payloadArray, $actionData);

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Student exam data retrieved successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve student exam data: '.$e->getMessage(),
            ], 500);
        }
    }
}
