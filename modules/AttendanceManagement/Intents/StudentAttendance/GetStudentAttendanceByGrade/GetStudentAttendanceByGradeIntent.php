<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByGrade;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetStudentAttendanceByGradeIntent
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
            $result = GetStudentAttendanceByGradeAction::run($payloadArray, $actionData);

            // Response Data Validation
            $getStudentAttendanceByGradeResDTO = GetStudentAttendanceByGradeResDTO::validate($result);

            return response()->json([
                'status' => 'success',
                'message' => 'Multi-class attendance data retrieved successfully',
                'data' => $getStudentAttendanceByGradeResDTO,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
