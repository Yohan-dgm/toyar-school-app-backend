<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineGradeDashboard;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\DisciplineManagement\Support\DisciplineMarksCalculator;
use Modules\StudentManagement\Models\Student;

class GetDisciplineGradeDashboardAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getDisciplineGradeDashboardUserDTO = GetDisciplineGradeDashboardUserDTO::validate($payloadArray);

        $academicYear = $getDisciplineGradeDashboardUserDTO['academic_year'] ?? DisciplineMarksCalculator::currentAcademicYear();

        $students = Student::select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id')
            ->whereIn('grade_level_class_id', $getDisciplineGradeDashboardUserDTO['grade_level_class_ids'])
            ->where('has_dropped_out', false)
            ->where('is_school_leaver', false)
            ->with(['grade_level_class' => function (Builder $gradeLevelClassQuery) {
                $gradeLevelClassQuery->select('id', 'name');
            }])
            ->get();

        $studentIds = $students->pluck('id');

        $deductionsByStudent = DisciplineRecord::whereIn('student_id', $studentIds)
            ->where('academic_year', $academicYear)
            ->where('status', 'Approved')
            ->where('is_active', true)
            ->groupBy('student_id')
            ->selectRaw('student_id, SUM(marks_deducted) as total_deducted')
            ->pluck('total_deducted', 'student_id');

        $bandDistribution = [
            'Outstanding Conduct' => 0,
            'Very Good Conduct' => 0,
            'Good Conduct' => 0,
            'Satisfactory Conduct' => 0,
            'Improvement Required' => 0,
            'Serious Improvement Required' => 0,
        ];

        $studentSummaries = $students->map(function ($student) use ($deductionsByStudent, &$bandDistribution) {
            $deducted = (int) ($deductionsByStudent[$student->id] ?? 0);
            $remainingMarks = max(0, DisciplineMarksCalculator::BASELINE_MARKS - $deducted);
            $conductRating = DisciplineMarksCalculator::conductRating($remainingMarks);
            $bandDistribution[$conductRating]++;

            return [
                'student_id' => $student->id,
                'full_name' => $student->full_name,
                'full_name_with_title' => $student->full_name_with_title,
                'admission_number' => $student->admission_number,
                'grade_level_class_id' => $student->grade_level_class_id,
                'grade_level_class' => $student->grade_level_class,
                'remaining_marks' => $remainingMarks,
                'conduct_rating' => $conductRating,
            ];
        })->values();

        return [
            'academic_year' => $academicYear,
            'baseline_marks' => DisciplineMarksCalculator::BASELINE_MARKS,
            'total_students' => $studentSummaries->count(),
            'band_distribution' => $bandDistribution,
            'students' => $studentSummaries,
        ];
    }
}
