<?php

namespace Modules\AccountManagement\Intents\StudentBillsData\GetStudentBillsData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetStudentBillsDataIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $payloadArray = $request->all();
            $actionData = [];

            $result = GetStudentBillsDataAction::run($payloadArray, $actionData);

            return response()->json([
                'status' => 'success',
                'data' => $result,
                'message' => 'Student bills data retrieved successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve student bills data: '.$e->getMessage(),
            ], 500);
        }
    }
}
