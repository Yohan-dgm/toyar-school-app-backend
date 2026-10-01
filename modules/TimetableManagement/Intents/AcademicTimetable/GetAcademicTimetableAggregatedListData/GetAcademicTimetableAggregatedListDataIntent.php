<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableAggregatedListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAcademicTimetableAggregatedListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization

            // 2. User Data Validation
            $getAcademicTimetableAggregatedListDataUserDTO = GetAcademicTimetableAggregatedListDataUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1 - Get Aggregated Data
            $actionData = [];

            $aggregatedData = GetAcademicTimetableAggregatedListDataAction::run($getAcademicTimetableAggregatedListDataUserDTO, $actionData);

            // After Intent

            // Return Response
            return $aggregatedData;
        } catch (\Throwable $th) {
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
                        'message' => 'Academic timetable aggregated data retrieved successfully',
                        'data' => $result->items(),
                        'metadata' => [
                            'current_page' => $result->currentPage(),
                            'last_page' => $result->lastPage(),
                            'per_page' => $result->perPage(),
                            'total' => $result->total(),
                        ],
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => 'Failed to retrieve academic timetable aggregated data',
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
