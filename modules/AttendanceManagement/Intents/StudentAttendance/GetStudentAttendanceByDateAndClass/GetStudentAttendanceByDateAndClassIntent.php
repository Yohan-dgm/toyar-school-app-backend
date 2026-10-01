<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByDateAndClass;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetStudentAttendanceByDateAndClassIntent
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Get the payload array from the request
            $payloadArray = $request->all();

            // Get the action data (user info from middleware)
            $actionData = [
                'user_id' => $request->user()->id ?? 1, // Default to 1 if no user
            ];

            // Call the action
            $result = GetStudentAttendanceByDateAndClassAction::run($payloadArray, $actionData);

            // Response Data Validation
            $getStudentAttendanceByDateAndClassResDTO = GetStudentAttendanceByDateAndClassResDTO::fromArray($result);

            return response()->json([
                'status' => 'success',
                'message' => 'Attendance data retrieved successfully',
                'data' => $getStudentAttendanceByDateAndClassResDTO,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
