<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentById;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetStudentByIdIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetStudentByIdAction::run($payloadArray, $actionData);

            $resDTO = GetStudentByIdResDTO::fromArray($result);

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
