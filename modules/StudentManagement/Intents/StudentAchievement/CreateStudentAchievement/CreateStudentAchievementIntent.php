<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\CreateStudentAchievement;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateStudentAchievementIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            $createStudentAchievementUserDTO = CreateStudentAchievementUserDTO::validate($request->all());

            $actionData = [];
            $actionData['created_by'] = $request->user()->id;
            $studentAchievement = CreateStudentAchievementAction::run($createStudentAchievementUserDTO, $actionData);

            DB::commit();

            return $studentAchievement;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => 'Student achievement created successfully',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to create student achievement',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
