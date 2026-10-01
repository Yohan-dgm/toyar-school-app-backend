<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\BulkCreateSportAttendance;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkCreateSportAttendanceIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $bulkCreateSportAttendanceUserDTO = BulkCreateSportAttendanceUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;

            $result = BulkCreateSportAttendanceAction::run($bulkCreateSportAttendanceUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
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
            if ($result && $result['success']) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => "Bulk sport attendance created successfully. {$result['created_count']} records created.",
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to create bulk sport attendance',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
