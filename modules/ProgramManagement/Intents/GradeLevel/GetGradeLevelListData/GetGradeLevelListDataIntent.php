<?php

namespace Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGradeLevelListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GradeLevel Data Validation
            $getGradeLevelListDataUserDTO = GetGradeLevelListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $gradeLevelListData = GetGradeLevelListDataAction::run($getGradeLevelListDataUserDTO, $actionData);
            $data['gradeLevel_count'] = DB::table('grade_level')->count();
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
            $GetGradeLevelListDataResDTO = GetGradeLevelListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGradeLevelListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
