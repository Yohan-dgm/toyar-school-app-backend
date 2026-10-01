<?php

namespace Modules\EducatorFeedbackManagement\Intents\Stats\GetStudentFeedbackStats;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\StudentManagement\Models\Student;

class GetStudentFeedbackStatsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $validatedData = GetStudentFeedbackStatsUserDTO::validate($payloadArray);

        // Get all active feedback categories
        $categories = EduFbCategory::where('is_active', true)->get();

        // Build the date filter conditions
        $dateFilters = $this->buildDateFilters($validatedData);

        // Build dynamic SELECT with category and status counts
        $selectRaw = $this->buildDynamicSelectRaw($categories);

        // Get all active students with their feedback counts
        $students = Student::select(
            'student.id',
            'student.full_name',
            'student.admission_number',
            'student.grade_level_id',
            'grade_level.name as grade_level_name'
        )
            ->where('student.has_dropped_out', false)
            ->where('student.is_school_leaver', false)
            ->leftJoin('edu_fb', function ($join) use ($dateFilters) {
                $join->on('student.id', '=', 'edu_fb.student_id');

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
            ->selectRaw($selectRaw)
            ->orderBy('feedback_count', 'desc')
            ->orderBy('student.full_name', 'asc')
            ->get()
            ->map(function ($student) use ($categories) {
                // Build categories array from dynamic columns
                $studentCategories = [];
                foreach ($categories as $category) {
                    $countKey = "category_{$category->id}_count";
                    $count = (int) ($student->$countKey ?? 0);

                    if ($count > 0) {
                        $studentCategories[] = [
                            'category_id' => $category->id,
                            'category_name' => $category->name,
                            'count' => $count,
                        ];
                    }
                }

                return [
                    'student_id' => $student->id,
                    'full_name' => $student->full_name,
                    'admission_number' => $student->admission_number,
                    'grade_level_id' => $student->grade_level_id,
                    'grade_level_name' => $student->grade_level_name ?? 'N/A',
                    'feedback_count' => (int) $student->feedback_count,
                    'accepted_count' => (int) $student->accepted_count,
                    'pending_count' => (int) $student->pending_count,
                    'categories' => $studentCategories,
                ];
            });

        // Calculate summary statistics
        $totalStudents = $students->count();
        $studentsWithFeedback = $students->where('feedback_count', '>', 0)->count();
        $totalFeedbackCount = $students->sum('feedback_count');
        $totalAccepted = $students->sum('accepted_count');
        $totalPending = $students->sum('pending_count');

        // Build filtered period string
        $filteredPeriod = $this->buildFilteredPeriodString($validatedData);

        // Build response data
        $responseData = [
            'summary' => [
                'total_students' => $totalStudents,
                'students_with_feedback' => $studentsWithFeedback,
                'total_feedback_count' => $totalFeedbackCount,
                'total_accepted' => $totalAccepted,
                'total_pending' => $totalPending,
                'filtered_period' => $filteredPeriod,
            ],
            'students' => $students->values()->toArray(),
            'categories' => $categories->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                ];
            })->toArray(),
        ];

        return $responseData;
    }

    /**
     * Build dynamic SELECT raw SQL for category and status counts
     */
    private function buildDynamicSelectRaw($categories): string
    {
        // Base counts
        $selectRaw = 'COUNT(edu_fb.id) as feedback_count';

        // Status counts (status = 2 is Accepted, others are Pending)
        // Only count actual feedback records, not NULL values from students with no feedback
        $selectRaw .= ', COUNT(CASE WHEN edu_fb.status = 2 THEN 1 END) as accepted_count';
        $selectRaw .= ', COUNT(CASE WHEN edu_fb.status IS NOT NULL AND edu_fb.status != 2 THEN 1 END) as pending_count';

        // Dynamic category counts
        foreach ($categories as $category) {
            $selectRaw .= ", COUNT(CASE WHEN edu_fb.edu_fb_category_id = {$category->id} THEN 1 END) as category_{$category->id}_count";
        }

        return $selectRaw;
    }

    /**
     * Build date filter conditions based on provided filters
     */
    private function buildDateFilters($validatedData): array
    {
        $filters = [];

        if (isset($validatedData['period'])) {
            $now = now();

            switch ($validatedData['period']) {
                case 'this_week':
                    // Get start of week (Monday) and end of week (Sunday)
                    $startOfWeek = $now->copy()->startOfWeek()->format('Y-m-d 00:00:00');
                    $endOfWeek = $now->copy()->endOfWeek()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfWeek}' AND '{$endOfWeek}'";
                    break;

                case 'this_month':
                    // Get first day and last day of current month
                    $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                    $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfMonth}' AND '{$endOfMonth}'";
                    break;

                case 'this_year':
                    // Get January 1 and December 31 of current year
                    $startOfYear = $now->copy()->startOfYear()->format('Y-m-d 00:00:00');
                    $endOfYear = $now->copy()->endOfYear()->format('Y-m-d 23:59:59');
                    $filters[] = "edu_fb.created_at BETWEEN '{$startOfYear}' AND '{$endOfYear}'";
                    break;
            }
        }

        return $filters;
    }

    /**
     * Build human-readable filtered period string
     */
    private function buildFilteredPeriodString($validatedData): string
    {
        if (isset($validatedData['period'])) {
            $now = now();

            switch ($validatedData['period']) {
                case 'this_week':
                    $startOfWeek = $now->copy()->startOfWeek()->format('M d');
                    $endOfWeek = $now->copy()->endOfWeek()->format('M d, Y');
                    return "This Week ({$startOfWeek} - {$endOfWeek})";

                case 'this_month':
                    $monthYear = $now->format('F Y');
                    return "This Month ({$monthYear})";

                case 'this_year':
                    $year = $now->format('Y');
                    return "This Year ({$year})";
            }
        }

        return 'All time';
    }
}
