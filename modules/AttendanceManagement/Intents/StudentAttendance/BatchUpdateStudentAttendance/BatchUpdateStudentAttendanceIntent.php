<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchUpdateStudentAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BatchUpdateStudentAttendanceIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get the payload array from the request
            $payloadArray = $request->all();

            // Get the action data (user info from middleware)
            $actionData = [
                'created_by' => $request->user()->id ?? 1, // Default to 1 if no user
            ];

            // Call the action
            $result = BatchUpdateStudentAttendanceAction::run($payloadArray, $actionData);

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
