<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetStudentDisciplineSummary;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\DisciplineManagement\Support\DisciplineMarksCalculator;
use Modules\StudentManagement\Models\Student;

class GetStudentDisciplineSummaryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getStudentDisciplineSummaryUserDTO = GetStudentDisciplineSummaryUserDTO::validate($payloadArray);

        $student = Student::select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id')
            ->with(['grade_level_class' => function (Builder $gradeLevelClassQuery) {
                $gradeLevelClassQuery->select('id', 'name');
            }])
            ->find($getStudentDisciplineSummaryUserDTO['student_id']);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        $academicYear = $getStudentDisciplineSummaryUserDTO['academic_year'] ?? DisciplineMarksCalculator::currentAcademicYear();

        $remainingMarks = DisciplineMarksCalculator::remainingMarks($student->id, $academicYear);
        $conductRating = DisciplineMarksCalculator::conductRating($remainingMarks);

        $records = DisciplineRecord::where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->where('is_active', true)
            ->with([
                'misconduct_level' => function (Builder $misconductLevelQuery) {
                    $misconductLevelQuery->select('id', 'level_number', 'level_name');
                },
                'reported_by_user' => function (Builder $userQuery) {
                    $userQuery->select('id', 'call_name_with_title');
                },
                'reviewed_by_user' => function (Builder $userQuery) {
                    $userQuery->select('id', 'call_name_with_title');
                },
            ])
            ->orderBy('incident_date', 'desc')
            ->get();

        $availableAcademicYears = DisciplineRecord::where('student_id', $student->id)
            ->where('is_active', true)
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');

        return [
            'student' => $student,
            'academic_year' => $academicYear,
            'baseline_marks' => DisciplineMarksCalculator::BASELINE_MARKS,
            'remaining_marks' => $remainingMarks,
            'conduct_rating' => $conductRating,
            'records' => $records,
            'available_academic_years' => $availableAcademicYears,
        ];
    }
}
