<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\GetClassTeacherList;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetClassTeacherListIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization
            // TODO: Add authorization check if needed

            // 2. Get filters from request
            $filters = $request->only([
                'user_id',
                'grade_level_class_id',
                'academic_year',
                'is_active',
                'current',
            ]);

            // 3. Action
            $classTeachers = GetClassTeacherListAction::run($filters);

            // 4. Return Response
            return $classTeachers;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => 'Class teachers retrieved successfully',
                    'data' => $result,
                    'metadata' => [
                        'total' => $result->count(),
                    ],
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                    'data' => null,
                    'metadata' => null,
                ],
                500
            );
        }
    }
}
