<?php

namespace Modules\AttendanceManagement\Intents\Stats\GetStudentAttendanceStats;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\StudentManagement\Models\Student;

class GetStudentAttendanceStatsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $validatedData = GetStudentAttendanceStatsUserDTO::validate($payloadArray);

        // Build date filter conditions
        $dateFilters = $this->buildDateFilters($validatedData);

        // Get all active students with their attendance counts
        $students = Student::select(
            'student.id',
            'student.full_name',
            'student.admission_number',
            'student.grade_level_id',
            'grade_level.name as grade_level_name'
        )
            ->where('student.has_dropped_out', false)
            ->leftJoin('student_attendance', function ($join) use ($dateFilters) {
                $join->on('student.id', '=', 'student_attendance.student_id');

                // Apply date filters if provided
                if (!empty($dateFilters)) {
                    foreach ($dateFilters as $filter) {
                        $join->whereRaw($filter);
                    }
                }
            })
            ->leftJoin('grade_level', 'student.grade_level_id', '=', 'grade_level.id')
            ->groupBy(
                'student.id',
                'student.full_name',
                'student.admission_number',
                'student.grade_level_id',
                'grade_level.name'
            )
            ->selectRaw('COUNT(CASE WHEN student_attendance.attendance_type_id = 1 THEN 1 END) as in_time_count')
            ->selectRaw('COUNT(CASE WHEN student_attendance.attendance_type_id = 2 THEN 1 END) as out_time_count')
            ->selectRaw('COUNT(CASE WHEN student_attendance.attendance_type_id = 3 THEN 1 END) as leave_count')
            ->selectRaw('COUNT(CASE WHEN student_attendance.attendance_type_id = 4 THEN 1 END) as absent_count')
            ->selectRaw('COUNT(student_attendance.id) as total_attendance_records')
            ->orderBy('grade_level.name', 'asc')
            ->orderBy('student.full_name', 'asc')
            ->get()
            ->map(function ($student) {
                return [
                    'student_id' => $student->id,
                    'full_name' => $student->full_name,
                    'admission_number' => $student->admission_number,
                    'grade_level_id' => $student->grade_level_id,
                    'grade_level_name' => $student->grade_level_name ?? 'N/A',
                    'in_time_count' => (int) $student->in_time_count,
                    'out_time_count' => (int) $student->out_time_count,
                    'leave_count' => (int) $student->leave_count,
                    'absent_count' => (int) $student->absent_count,
                    'total_attendance_records' => (int) $student->total_attendance_records,
                ];
            });

        // Calculate summary statistics
        $totalStudents = $students->count();
        $studentsWithAttendance = $students->where('total_attendance_records', '>', 0)->count();
        $totalInTime = $students->sum('in_time_count');
        $totalOutTime = $students->sum('out_time_count');
        $totalLeave = $students->sum('leave_count');
        $totalAbsent = $students->sum('absent_count');

        // Build filter display string
        $filterDisplay = $this->buildFilterDisplayString($validatedData);

        // Build response data
        $responseData = [
            'summary' => [
                'total_students' => $totalStudents,
                'students_with_attendance' => $studentsWithAttendance,
                'total_in_time' => $totalInTime,
                'total_out_time' => $totalOutTime,
                'total_leave' => $totalLeave,
                'total_absent' => $totalAbsent,
                'filter_type' => $validatedData['filter_type'],
                'filter_display' => $filterDisplay,
            ],
            'students' => $students->values()->toArray(),
        ];

        return $responseData;
    }

    /**
     * Build date filter conditions based on filter type
     */
    private function buildDateFilters($validatedData): array
    {
        $filters = [];
        $filterType = $validatedData['filter_type'];

        switch ($filterType) {
            case 'month':
                // Month filter requires year and month
                if (!isset($validatedData['year']) || !isset($validatedData['month'])) {
                    throw new \Exception('Year and month are required for month filter');
                }
                $year = $validatedData['year'];
                $month = $validatedData['month'];
                // PostgreSQL syntax for YEAR and MONTH
                $filters[] = "EXTRACT(YEAR FROM student_attendance.date) = {$year}";
                $filters[] = "EXTRACT(MONTH FROM student_attendance.date) = {$month}";
                break;

            case 'year':
                // Year filter requires year
                if (!isset($validatedData['year'])) {
                    throw new \Exception('Year is required for year filter');
                }
                $year = $validatedData['year'];
                // PostgreSQL syntax for YEAR
                $filters[] = "EXTRACT(YEAR FROM student_attendance.date) = {$year}";
                break;

            case 'term':
                // Term filter requires term_id (1, 2, or 3)
                if (!isset($validatedData['term_id'])) {
                    throw new \Exception('Term ID is required for term filter');
                }

                $termNumber = $validatedData['term_id'];
                
                // Define hardcoded term date ranges
                $termDates = [
                    1 => ['start' => '2024-09-01', 'end' => '2024-12-31'], // 1st Term
                    2 => ['start' => '2025-01-01', 'end' => '2025-04-30'], // 2nd Term
                    3 => ['start' => '2025-05-01', 'end' => '2025-08-31'], // 3rd Term
                ];
                
                if (!isset($termDates[$termNumber])) {
                    throw new \Exception('Invalid term number');
                }
                
                $startDate = $termDates[$termNumber]['start'];
                $endDate = $termDates[$termNumber]['end'];
                $filters[] = "student_attendance.date BETWEEN '{$startDate}' AND '{$endDate}'";
                break;
        }

        return $filters;
    }

    /**
     * Build human-readable filter display string
     */
    private function buildFilterDisplayString($validatedData): string
    {
        $filterType = $validatedData['filter_type'];

        switch ($filterType) {
            case 'month':
                $year = $validatedData['year'];
                $month = $validatedData['month'];
                $monthName = date('F', mktime(0, 0, 0, $month, 1));
                return "{$monthName} {$year}";

            case 'year':
                $year = $validatedData['year'];
                return "Year {$year}";

            case 'term':
                $termId = $validatedData['term_id'] ?? 0;
                $termNames = [
                    1 => '1st Term (Sep - Dec 2024)',
                    2 => '2nd Term (Jan - Apr 2025)',
                    3 => '3rd Term (May - Aug 2025)',
                ];
                return $termNames[$termId] ?? 'Unknown Term';

            default:
                return 'All Time';
        }
    }
}
