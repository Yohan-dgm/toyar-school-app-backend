<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\BulkCreateAcademicTimetable;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkCreateAcademicTimetableIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $bulkCreateAcademicTimetableUserDTO = BulkCreateAcademicTimetableUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['created_by'] = $request->user()->id;

            $academicTimetables = BulkCreateAcademicTimetableAction::run($bulkCreateAcademicTimetableUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $academicTimetables;
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
                        'message' => 'Academic timetables created successfully',
                        'data' => $result,
                        'metadata' => [
                            'total_created' => count($result),
                        ],
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to create academic timetables',
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
