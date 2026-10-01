<?php

namespace Modules\EducatorManagement\Intents\Educator\GetEducatorClassStudents;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEducatorClassStudentsIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization - authenticated user passed from middleware

            // Student Data Validation
            $getEducatorClassStudentsUserDTO = GetEducatorClassStudentsUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['authenticatedUser'] = $request->user();
            $studentListData = GetEducatorClassStudentsAction::run($getEducatorClassStudentsUserDTO, $actionData);
            
            // Get count of students for this educator
            $data['student_count'] = $studentListData->total();
            
            // After Intent

            // Return Response
            return array_merge($studentListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $getEducatorClassStudentsResDTO = GetEducatorClassStudentsResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getEducatorClassStudentsResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}