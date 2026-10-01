<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\GetSportAttendanceAggregatedListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportAttendanceManagement\Models\SportAttendance;

class GetSportAttendanceAggregatedListDataIntent
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

            // Action 1 - Get Aggregated Data
            $query = SportAttendance::select([
                'sport_attendance.student_id',
                'sport_attendance.sport_activity',
                'sport_attendance.attendance_type_id',
                'sport_attendance.coach_id',
                DB::raw('COUNT(*) as total_attendance'),
                DB::raw('COUNT(CASE WHEN attendance_types.name = "Present" THEN 1 END) as present_count'),
                DB::raw('COUNT(CASE WHEN attendance_types.name = "Absent" THEN 1 END) as absent_count'),
                DB::raw('COUNT(CASE WHEN attendance_types.name = "Late" THEN 1 END) as late_count'),
                DB::raw('MIN(sport_attendance.date) as first_attendance_date'),
                DB::raw('MAX(sport_attendance.date) as last_attendance_date'),
            ])
                ->join('attendance_types', 'sport_attendance.attendance_type_id', '=', 'attendance_types.id')
                ->with(['student', 'attendance_type', 'coach']);

            // Apply filters
            if (isset($filters['student_id'])) {
                $query->where('sport_attendance.student_id', $filters['student_id']);
            }

            if (isset($filters['sport_activity'])) {
                $query->where('sport_attendance.sport_activity', 'like', '%'.$filters['sport_activity'].'%');
            }

            if (isset($filters['coach_id'])) {
                $query->where('sport_attendance.coach_id', $filters['coach_id']);
            }

            // Apply date range filters
            if (isset($filters['date_from'])) {
                $query->where('sport_attendance.date', '>=', $filters['date_from']);
            }

            if (isset($filters['date_to'])) {
                $query->where('sport_attendance.date', '<=', $filters['date_to']);
            }

            // Group by
            $query->groupBy('sport_attendance.student_id', 'sport_attendance.sport_activity', 'sport_attendance.attendance_type_id', 'sport_attendance.coach_id');

            // Order by
            $query->orderBy('total_attendance', 'desc');

            // Pagination
            $perPage = $filters['per_page'] ?? 15;
            $aggregatedData = $query->paginate($perPage);

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
                        'message' => 'Aggregated sport attendance data retrieved successfully',
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
                        'message' => 'Failed to retrieve aggregated sport attendance data',
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
