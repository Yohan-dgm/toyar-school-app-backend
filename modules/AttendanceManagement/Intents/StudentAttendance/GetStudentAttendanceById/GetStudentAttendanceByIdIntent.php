<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceById;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;

class GetStudentAttendanceByIdIntent
{
    use AsController;

    public function asController(Request $request): \Illuminate\Http\JsonResponse
    {
        $payloadArray = $request->all();
        $actionData = [
            'user_id' => $request->user()?->id,
            'username' => $request->user()?->call_name_with_title ?? 'System',
        ];

        $result = GetStudentAttendanceByIdAction::run($payloadArray, $actionData);

        return response()->json($result);
    }
}
