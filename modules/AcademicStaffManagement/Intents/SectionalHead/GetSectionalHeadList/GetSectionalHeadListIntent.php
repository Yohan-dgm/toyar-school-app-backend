<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\GetSectionalHeadList;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSectionalHeadListIntent
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
                'grade_level_id',
                'academic_year',
                'is_active',
                'current',
            ]);

            // 3. Action
            $sectionalHeads = GetSectionalHeadListAction::run($filters);

            // 4. Return Response
            return $sectionalHeads;
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
                    'message' => 'Sectional heads retrieved successfully',
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
