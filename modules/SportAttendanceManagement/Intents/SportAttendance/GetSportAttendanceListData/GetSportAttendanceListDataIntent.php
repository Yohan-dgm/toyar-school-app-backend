<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\GetSportAttendanceListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportAttendanceManagement\Models\SportAttendance;

class GetSportAttendanceListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization

            // 2. User Data Validation
            $filters = $request->all();

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1 - Get Data
            $query = SportAttendance::with(['student', 'attendance_type', 'user', 'coach']);

            // Apply filters
            if (isset($filters['student_id'])) {
                $query->where('student_id', $filters['student_id']);
            }

            if (isset($filters['date'])) {
                $query->where('date', $filters['date']);
            }

            if (isset($filters['sport_activity'])) {
                $query->where('sport_activity', 'like', '%'.$filters['sport_activity'].'%');
            }

            if (isset($filters['attendance_type_id'])) {
                $query->where('attendance_type_id', $filters['attendance_type_id']);
            }

            if (isset($filters['coach_id'])) {
                $query->where('coach_id', $filters['coach_id']);
            }

            // Apply date range filters
            if (isset($filters['date_from'])) {
                $query->where('date', '>=', $filters['date_from']);
            }

            if (isset($filters['date_to'])) {
                $query->where('date', '<=', $filters['date_to']);
            }

            // Order by
            $query->orderBy('date', 'desc')->orderBy('time', 'desc');

            // Pagination
            $perPage = $filters['per_page'] ?? 15;
            $sportAttendances = $query->paginate($perPage);

            // After Intent

            // Return Response
            return $sportAttendances;
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
                        'message' => 'Sport attendance data retrieved successfully',
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
                        'message' => 'Failed to retrieve sport attendance data',
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
