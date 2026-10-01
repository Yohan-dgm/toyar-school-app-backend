<?php

namespace Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingDashboard;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\StudentManagement\Models\Student;

class GetStudentRatingDashboardAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $validatedData = GetStudentRatingDashboardUserDTO::validate($payloadArray);

        // Get student information
        $student = Student::select('id', 'full_name', 'student_calling_name', 'admission_number', 'grade_level_id')
            ->with(['grade_level' => function ($query) {
                $query->select('id', 'name');
            }])
            ->find($validatedData['student_id']);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        // Build query for feedback data - ONLY include status = 2 records
        $query = EduFb::where('student_id', $validatedData['student_id'])
            ->where('status', 2);

        // Apply date filters
        if (isset($validatedData['year'])) {
            // Determine academic year dates (Sep 1 to Aug 31)
            $currentDate = now();
            $requestedYear = $validatedData['year'];

            // If current date is before Sep 1, use previous academic year logic
            // If current date is Sep 1 or later, use current academic year logic
            if ($currentDate->month < 9) {
                // Before Sep 1: Show previous academic year (requested_year Sep 1 to requested_year+1 Aug 31)
                $academicYearStart = $requestedYear.'-09-01';
                $academicYearEnd = ($requestedYear + 1).'-08-31';
            } else {
                // On/after Sep 1: Show current academic year (requested_year Sep 1 to requested_year+1 Aug 31)
                $academicYearStart = $requestedYear.'-09-01';
                $academicYearEnd = ($requestedYear + 1).'-08-31';
            }

            $query->whereBetween('created_at', [$academicYearStart.' 00:00:00', $academicYearEnd.' 23:59:59']);
        }

        if (isset($validatedData['month'])) {
            $query->whereMonth('created_at', $validatedData['month']);
        }

        // Get total count of records
        $totalRecords = $query->count();

        // Get category-wise statistics
        $categoryStats = $query->select(
            'edu_fb_category_id',
            DB::raw('COUNT(*) as record_count'),
            DB::raw('ROUND(AVG(rating), 2) as average_rating')
        )
            ->groupBy('edu_fb_category_id')
            ->get()
            ->keyBy('edu_fb_category_id');

        // Get all categories (1-13) to ensure complete data
        $allCategories = EduFbCategory::select('id', 'name', 'is_active')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        // Build category data first
        $categories = [];
        foreach ($allCategories as $category) {
            $stats = $categoryStats->get($category->id);

            $categories[] = [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'average_rating' => $stats ? (float) $stats->average_rating : 0,
                'record_count' => $stats ? $stats->record_count : 0,
            ];
        }

        // Calculate weighted overall average from category data
        $weightedSum = 0;
        $totalRecordsFromCategories = 0;

        foreach ($categories as $category) {
            if ($category['record_count'] > 0) {
                $weightedSum += $category['average_rating'] * $category['record_count'];
                $totalRecordsFromCategories += $category['record_count'];
            }
        }

        $overallAverage = $totalRecordsFromCategories > 0 ? round($weightedSum / $totalRecordsFromCategories, 2) : 0;

        // Build filtered period string
        $filteredPeriod = '';
        if (isset($validatedData['year']) && isset($validatedData['month'])) {
            $filteredPeriod = sprintf('Academic Year %d-%d (Month %02d)', $validatedData['year'], $validatedData['year'] + 1, $validatedData['month']);
        } elseif (isset($validatedData['year'])) {
            $filteredPeriod = sprintf('Academic Year %d-%d', $validatedData['year'], $validatedData['year'] + 1);
        } elseif (isset($validatedData['month'])) {
            $filteredPeriod = 'Month '.$validatedData['month'];
        } else {
            $filteredPeriod = 'All time';
        }

        // Build response data
        $responseData = [
            'student_info' => [
                'id' => $student->id,
                'full_name' => $student->full_name,
                'student_calling_name' => $student->student_calling_name,
                'admission_number' => $student->admission_number,
                'grade_level' => $student->grade_level ? [
                    'id' => $student->grade_level->id,
                    'name' => $student->grade_level->name,
                ] : null,
            ],
            'summary' => [
                'total_records' => $totalRecords,
                'average_overall' => $overallAverage,
                'filtered_period' => $filteredPeriod,
                'status_filter' => 2,
                'categories_with_data' => collect($categories)->where('record_count', '>', 0)->count(),
                'categories_total' => count($categories),
            ],
            'categories' => $categories,
        ];

        return $responseData;
    }
}
