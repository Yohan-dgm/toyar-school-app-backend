<?php

namespace Modules\ParentManagement\Intents\StudentGuardian\GetStudentGuardianListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentGuardianListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentGuardian Data Validation
            $getStudentGuardianListDataUserDTO = GetStudentGuardianListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $studentGuardianListData = GetStudentGuardianListDataAction::run($getStudentGuardianListDataUserDTO, $actionData);
            $data['student_guardian_count'] = DB::table('student_guardian')->count();
            // After Intent

            // Return Response
            return array_merge($studentGuardianListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentGuardianListDataResDTO = GetStudentGuardianListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentGuardianListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
