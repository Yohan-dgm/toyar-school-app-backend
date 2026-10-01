<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BatchCreateStudentAttendanceIntent
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
            $result = BatchCreateStudentAttendanceAction::run($payloadArray, $actionData);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => [
                    'processed_students' => $result['processed_students'],
                    'created_count' => $result['created_count'],
                    'reasons_count' => $result['reasons_count'] ?? 0,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create batch attendance',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
