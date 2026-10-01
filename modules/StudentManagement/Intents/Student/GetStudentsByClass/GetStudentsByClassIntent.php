<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentsByClass;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentsByClassIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Student Data Validation
            $getStudentsByClassUserDTO = GetStudentsByClassUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $actionData['username'] = $request->user()->username;
            $studentsByClassData = GetStudentsByClassAction::run($getStudentsByClassUserDTO, $actionData);

            // After Intent

            // Log

            // Return
            return new JsonResponse([
                'status' => 'success',
                'message' => 'Students retrieved successfully',
                'data' => $studentsByClassData,
            ], 200);

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Failed to retrieve students: '.$e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
