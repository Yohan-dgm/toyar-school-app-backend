<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteStudentAttendanceIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get the payload array from the request
            $payloadArray = $request->all();

            // Get the action data (user info from middleware)
            $actionData = [
                'deleted_by' => $request->user()->id ?? 1,
            ];

            // Call the action
            $result = DeleteStudentAttendanceAction::run($payloadArray, $actionData);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => [
                    'deleted_attendance' => $result['deleted_attendance'],
                    'deleted_by' => $result['deleted_by'],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attendance record',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
