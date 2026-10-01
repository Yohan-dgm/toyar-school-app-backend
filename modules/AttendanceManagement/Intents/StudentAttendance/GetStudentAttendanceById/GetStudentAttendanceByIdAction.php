<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceById;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;

class GetStudentAttendanceByIdAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $validatedData = GetStudentAttendanceByIdUserDTO::validate($payloadArray);

        // Build base query with required student_id filter
        $attendanceQuery = StudentAttendance::with([
            'attendance_type' => function (Builder $attendance_type_query) {
                $attendance_type_query->select('id', 'name');
            },
            'grade_level_class' => function (Builder $grade_level_class_query) {
                $grade_level_class_query->select('id', 'name');
            },
            'user' => function (Builder $user_query) {
                $user_query->select('id', 'call_name_with_title');
            },
            'attendance_reason' => function (Builder $attendance_reason_query) {
                $attendance_reason_query->select('id', 'attendance_id', 'reason', 'created_by', 'created_at')
                    ->with(['created_by_user' => function (Builder $reason_user_query) {
                        $reason_user_query->select('id', 'call_name_with_title');
                    }]);
            },
        ])
            ->where('student_id', $validatedData['student_id']);

        // Apply date filters
        if (isset($validatedData['date_from'])) {
            $attendanceQuery->whereDate('date', '>=', $validatedData['date_from']);
        }

        if (isset($validatedData['date_to'])) {
            $attendanceQuery->whereDate('date', '<=', $validatedData['date_to']);
        }

        // Apply search phrase filter
        if (isset($validatedData['search_phrase']) && ! empty($validatedData['search_phrase'])) {
            $attendanceQuery->where(function (Builder $search_query) use ($validatedData) {
                $search_query->where('notes', 'ILIKE', '%'.$validatedData['search_phrase'].'%')
                    ->orWhereHas('attendance_reason', function (Builder $reason_search) use ($validatedData) {
                        $reason_search->where('reason', 'ILIKE', '%'.$validatedData['search_phrase'].'%');
                    });
            });
        }

        // Select specific columns for main query
        $attendanceQuery->select(
            'id',
            'student_id',
            'grade_level_class_id',
            'date',
            'time',
            'attendance_type_id',
            'notes',
            'created_by',
            'created_at',
            'updated_at'
        );

        // Order by date desc, then by attendance_type_id to prioritize in-time records
        $attendanceQuery->orderBy('date', 'desc')->orderBy('attendance_type_id', 'asc');

        // Get all records first (without pagination for consolidation)
        $allAttendanceRecords = $attendanceQuery->get();

        // Group by date and consolidate records
        $consolidatedRecords = collect();
        $groupedByDate = $allAttendanceRecords->groupBy('date');

        foreach ($groupedByDate as $date => $dateRecords) {
            $inTimeRecord = $dateRecords->firstWhere('attendance_type_id', 1);
            $outTimeRecord = $dateRecords->firstWhere('attendance_type_id', 2);
            $lateRecord = $dateRecords->firstWhere('attendance_type_id', 3);
            $absentRecord = $dateRecords->firstWhere('attendance_type_id', 4);

            // Determine primary record and status
            $primaryRecord = $inTimeRecord ?? $lateRecord ?? $absentRecord;

            if (! $primaryRecord) {
                continue; // Skip if no valid record found
            }

            // Determine status and times
            if ($absentRecord) {
                $status = 'absent';
                $inTime = null;
                $outTime = null;
                $statusRecord = $absentRecord;
            } elseif ($lateRecord) {
                $status = 'late';
                $inTime = $lateRecord->time;
                $outTime = $outTimeRecord?->time;
                $statusRecord = $lateRecord;
            } else {
                $status = 'present';
                $inTime = $inTimeRecord?->time;
                $outTime = $outTimeRecord?->time;
                $statusRecord = $inTimeRecord;
            }

            // Create consolidated record
            $consolidatedRecord = (object) [
                'id' => $statusRecord->id,
                'student_id' => $statusRecord->student_id,
                'grade_level_class_id' => $statusRecord->grade_level_class_id,
                'date' => $statusRecord->date,
                'in_time' => $inTime,
                'out_time' => $outTime,
                'status' => $status,
                'attendance_type_id' => $statusRecord->attendance_type_id,
                'notes' => $statusRecord->notes,
                'created_by' => $statusRecord->created_by,
                'created_at' => $statusRecord->created_at,
                'updated_at' => $statusRecord->updated_at,
                'attendance_type' => $statusRecord->attendance_type,
                'grade_level_class' => $statusRecord->grade_level_class,
                'user' => $statusRecord->user,
                'attendance_reason' => $statusRecord->attendance_reason,
            ];

            $consolidatedRecords->push($consolidatedRecord);
        }

        // Apply attendance type filter after consolidation if needed
        if (isset($validatedData['attendance_type_id'])) {
            $filterType = $validatedData['attendance_type_id'];
            $consolidatedRecords = $consolidatedRecords->filter(function ($record) use ($filterType) {
                if ($filterType == 1) { // In time
                    return $record->status === 'present' || $record->status === 'late';
                } elseif ($filterType == 2) { // Out time
                    return $record->out_time !== null;
                } elseif ($filterType == 3) { // Late
                    return $record->status === 'late';
                } elseif ($filterType == 4) { // Absent
                    return $record->status === 'absent';
                }

                return true;
            });
        }

        // Validate page size limits
        $pageSize = min(max($validatedData['page_size'], 1), 100);
        $page = $validatedData['page'];

        // Manual pagination
        $total = $consolidatedRecords->count();
        $paginatedRecords = $consolidatedRecords->forPage($page, $pageSize);

        // Create paginator-like structure
        $attendanceListData = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedRecords->values(),
            $total,
            $pageSize,
            $page,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        return $attendanceListData;
    }
}
