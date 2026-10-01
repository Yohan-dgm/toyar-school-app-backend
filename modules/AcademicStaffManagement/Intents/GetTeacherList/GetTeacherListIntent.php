<?php

namespace Modules\AcademicStaffManagement\Intents\GetTeacherList;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTeacherListIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization
            // TODO: Add authorization check if needed

            // 2. Action
            $teachers = GetTeacherListAction::run();

            // 3. Return Response
            return $teachers;
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
                    'message' => 'Teachers retrieved successfully',
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
