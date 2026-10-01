<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetCurrentStudentAchievements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetCurrentStudentAchievementsIntent extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $payloadArray = $request->all();
            $actionData = [
                'request' => $request,
                'user' => $request->user(),
            ];

            $result = GetCurrentStudentAchievementsAction::run($payloadArray, $actionData);

            $resDTO = GetCurrentStudentAchievementsResDTO::fromArray($result);

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
