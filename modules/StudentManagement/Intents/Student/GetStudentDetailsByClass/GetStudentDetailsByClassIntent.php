<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentDetailsByClass;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentDetailsByClassIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Student Data Validation
            $getStudentDetailsByClassUserDTO = GetStudentDetailsByClassUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            if ($request->user()) {
                $actionData['user_id'] = $request->user()->id;
                $actionData['username'] = $request->user()->username ?? $request->user()->email;
            }

            $studentListData = GetStudentDetailsByClassAction::run($getStudentDetailsByClassUserDTO, $actionData);

            // Get total count of students in this class
            $data['student_count'] = DB::table('student')
                ->where('grade_level_class_id', $getStudentDetailsByClassUserDTO['grade_level_class_id'])
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->count();

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
            $GetStudentDetailsByClassResDTO = GetStudentDetailsByClassResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentDetailsByClassResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
