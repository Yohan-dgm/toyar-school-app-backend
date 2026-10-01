<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetStudentAchievements;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentAchievementsIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            $getStudentAchievementsUserDTO = GetStudentAchievementsUserDTO::validate($request->all());

            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $studentAchievementsListData = GetStudentAchievementsAction::run($getStudentAchievementsUserDTO, $actionData);
            $data['student_achievement_count'] = DB::table('student_achievement')->count();

            return array_merge($studentAchievementsListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            $getStudentAchievementsResDTO = GetStudentAchievementsResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getStudentAchievementsResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
