<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\CreateDisciplineRecord;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\DisciplineManagement\Support\DisciplineMarksCalculator;
use Modules\DisciplineManagement\Support\DisciplineParentNotifier;
use Modules\StudentManagement\Models\Student;

class CreateDisciplineRecordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createDisciplineRecordUserDTO = CreateDisciplineRecordUserDTO::validate($payloadArray);

        $student = Student::with('grade_level_class')->find($createDisciplineRecordUserDTO['student_id']);
        if (! $student) {
            throw new \Exception('Student not found');
        }

        $misconductLevel = DisciplineMisconductLevel::find($createDisciplineRecordUserDTO['misconduct_level_id']);
        if (! $misconductLevel) {
            throw new \Exception('Misconduct level not found');
        }

        // Deduction must fall within the level's indicative range unless an override reason is given
        $marksDeducted = $createDisciplineRecordUserDTO['marks_deducted'];
        $outOfRange = $marksDeducted < $misconductLevel->indicative_deduction_min
            || $marksDeducted > $misconductLevel->indicative_deduction_max;
        if ($outOfRange && empty($createDisciplineRecordUserDTO['override_reason'])) {
            throw new \Exception('marks_deducted is outside the selected level\'s indicative range ('.$misconductLevel->indicative_deduction_min.'-'.$misconductLevel->indicative_deduction_max.'); provide override_reason to proceed.');
        }

        $incidentDate = Carbon::parse($createDisciplineRecordUserDTO['incident_date']);

        // Level's approval_tier 1 -> auto-approved; 2/3 -> pending management/committee review
        $isAutoApproved = (int) $misconductLevel->approval_tier === 1;

        // System Data Prep
        $system_data = [];
        $system_data['academic_year'] = DisciplineMarksCalculator::academicYearForDate($incidentDate);
        $system_data['grade_class_at_time'] = $student->grade_level_class->name ?? null;
        $system_data['status'] = $isAutoApproved ? 'Approved' : 'Pending';
        $system_data['reported_by'] = $actionData['created_by'];
        $system_data['reviewed_by'] = $isAutoApproved ? $actionData['created_by'] : null;
        $system_data['reviewed_date'] = $isAutoApproved ? Carbon::now()->toDateString() : null;
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createDisciplineRecordSystemDTO = CreateDisciplineRecordSystemDTO::validate($system_data);

        // Final Data Validation
        $createDisciplineRecordDTO = CreateDisciplineRecordDTO::validate(array_merge($createDisciplineRecordUserDTO, $createDisciplineRecordSystemDTO));

        $disciplineRecord = DisciplineRecord::create($createDisciplineRecordDTO);

        // Level 1 records are auto-approved immediately - notify the parent
        // now since no separate approve step will ever happen for this record
        if ($isAutoApproved) {
            DisciplineParentNotifier::notify($disciplineRecord);
        }

        return $disciplineRecord;
    }
}
