<?php

namespace Modules\SystemEntityManagement\Intents\GradeLevelClass\GetGradeLevelClassListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGradeLevelClassListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GradeLevelClass Data Validation
            $getGradeLevelClassListDataUserDTO = GetGradeLevelClassListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1=
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $gradeLevelClassListData = GetGradeLevelClassListDataAction::run($getGradeLevelClassListDataUserDTO, $actionData);
            $data['grade_level_class_count'] = DB::table('grade_level_class')->count();
            // After Intent

            // Return Response
            return array_merge($gradeLevelClassListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetGradeLevelClassListDataResDTO = GetGradeLevelClassListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGradeLevelClassListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
