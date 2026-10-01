<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\DeleteSectionalHead;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteSectionalHeadIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization
            // TODO: Add authorization check if needed

            // 2. Validate ID
            $request->validate([
                'id' => 'required|integer|exists:sectional_head,id',
            ]);

            // 3. Action
            $result = DeleteSectionalHeadAction::run($request->id);

            DB::commit();

            // 4. Return Response
            return $result;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => 'Sectional head deleted successfully',
                        'data' => null,
                        'metadata' => null,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to delete sectional head',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
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
