<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendanceByStudentId;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetTodayStudentAttendanceByStudentIdIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetTodayStudentAttendanceByStudentIdAction::run($payloadArray, $actionData);

            $resDTO = GetTodayStudentAttendanceByStudentIdResDTO::fromArray($result);

            return response()->json([
                'status' => 'success',
                'data' => $resDTO->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
