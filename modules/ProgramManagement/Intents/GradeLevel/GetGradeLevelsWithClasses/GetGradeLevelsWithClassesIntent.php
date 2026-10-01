<?php

namespace Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelsWithClasses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGradeLevelsWithClassesIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GradeLevel Data Validation
            $getGradeLevelsWithClassesUserDTO = GetGradeLevelsWithClassesUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $gradeLevelListData = GetGradeLevelsWithClassesAction::run($getGradeLevelsWithClassesUserDTO, $actionData);
            $data['grade_level_count'] = DB::table('grade_level')->count();
            // After Intent

            // Return Response
            return array_merge($gradeLevelListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetGradeLevelsWithClassesResDTO = GetGradeLevelsWithClassesResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGradeLevelsWithClassesResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
