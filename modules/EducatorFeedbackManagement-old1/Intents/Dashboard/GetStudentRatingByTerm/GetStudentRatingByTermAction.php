<?php

namespace Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingByTerm;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFb;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\StudentManagement\Models\Student;

class GetStudentRatingByTermAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $validatedData = GetStudentRatingByTermUserDTO::validate($payloadArray);

        // Get student information
        $student = Student::select('id', 'full_name', 'student_calling_name', 'admission_number', 'grade_level_id')
            ->with(['grade_level' => function ($query) {
                $query->select('id', 'name');
            }])
            ->find($validatedData['student_id']);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        // Use current year if not provided
        $academicYear = $validatedData['year'] ?? date('Y');

        // Get all categories (1-13) to ensure complete data
        $allCategories = EduFbCategory::select('id', 'name', 'is_active')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        // Define term date ranges
        $termRanges = $this->getTermDateRanges($academicYear);

        // Calculate data for each term
        $terms = [];
        $yearlyTotalRecords = 0;
        $yearlyWeightedSum = 0;
        $termsWithData = 0;

        foreach ($termRanges as $termNumber => $termInfo) {
            $termData = $this->calculateTermData(
                $validatedData['student_id'],
                $termInfo['start'],
                $termInfo['end'],
                $allCategories,
                $termNumber,
                $termInfo['name']
            );

            $terms[] = $termData;

            // Accumulate yearly statistics
            if ($termData['summary']['total_records'] > 0) {
                $yearlyTotalRecords += $termData['summary']['total_records'];
                $yearlyWeightedSum += $termData['summary']['average_overall'] * $termData['summary']['total_records'];
                $termsWithData++;
            }
        }

        // Calculate yearly overall average
        $yearlyOverallAverage = $yearlyTotalRecords > 0 ? round($yearlyWeightedSum / $yearlyTotalRecords, 2) : 0;

        // Find best performing term
        $bestPerformingTerm = 0;
        $bestAverage = 0;
        foreach ($terms as $term) {
            if ($term['summary']['average_overall'] > $bestAverage) {
                $bestAverage = $term['summary']['average_overall'];
                $bestPerformingTerm = $term['term_number'];
            }
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
            'academic_year' => $academicYear,
            'terms' => $terms,
            'yearly_summary' => [
                'total_records_all_terms' => $yearlyTotalRecords,
                'average_overall_yearly' => $yearlyOverallAverage,
                'best_performing_term' => $bestPerformingTerm,
                'terms_with_data' => $termsWithData,
            ],
        ];

        return $responseData;
    }

    private function getTermDateRanges($year)
    {
        return [
            1 => [
                'start' => "$year-09-01",
                'end' => "$year-12-31",
                'name' => 'Term 1 (Sep-Dec)',
            ],
            2 => [
                'start' => ($year + 1).'-01-01',
                'end' => ($year + 1).'-04-30',
                'name' => 'Term 2 (Jan-Apr)',
            ],
            3 => [
                'start' => ($year + 1).'-05-01',
                'end' => ($year + 1).'-08-30',
                'name' => 'Term 3 (May-Aug)',
            ],
        ];
    }

    private function calculateTermData($studentId, $startDate, $endDate, $allCategories, $termNumber, $termName)
    {
        // Build query for this term - ONLY include status = 2 records
        $query = EduFb::where('student_id', $studentId)
            ->where('status', 2)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        // Get total count of records for this term
        $totalRecords = $query->count();

        // Get category-wise statistics for this term
        $categoryStats = $query->select(
            'edu_fb_category_id',
            DB::raw('COUNT(*) as record_count'),
            DB::raw('ROUND(AVG(rating), 2) as average_rating')
        )
            ->groupBy('edu_fb_category_id')
            ->get()
            ->keyBy('edu_fb_category_id');

        // Build category data for this term
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

        // Calculate weighted overall average for this term
        $weightedSum = 0;
        $totalRecordsFromCategories = 0;

        foreach ($categories as $category) {
            if ($category['record_count'] > 0) {
                $weightedSum += $category['average_rating'] * $category['record_count'];
                $totalRecordsFromCategories += $category['record_count'];
            }
        }

        $termOverallAverage = $totalRecordsFromCategories > 0 ? round($weightedSum / $totalRecordsFromCategories, 2) : 0;

        return [
            'term_number' => $termNumber,
            'term_name' => $termName,
            'date_range' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
            'summary' => [
                'total_records' => $totalRecords,
                'average_overall' => $termOverallAverage,
                'categories_with_data' => collect($categories)->where('record_count', '>', 0)->count(),
            ],
            'categories' => $categories,
        ];
    }
}
