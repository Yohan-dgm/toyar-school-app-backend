<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetTodayStudentAttendanceIntent extends Controller
{
    public function __invoke(Request $request)
    {
        $payloadArray = $request->all();
        $actionData = [
            'request' => $request,
            'user' => $request->user(),
        ];

        $result = GetTodayStudentAttendanceAction::run($payloadArray, $actionData);

        $resDTO = GetTodayStudentAttendanceResDTO::fromArray($result);

        return response()->json([
            'status' => 'success',
            'data' => $resDTO->toArray(),
        ]);
    }
}
