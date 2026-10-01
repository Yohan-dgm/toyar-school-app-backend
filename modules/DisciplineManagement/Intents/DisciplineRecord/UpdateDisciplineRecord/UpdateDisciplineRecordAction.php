<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\UpdateDisciplineRecord;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\DisciplineManagement\Support\DisciplineMarksCalculator;

class UpdateDisciplineRecordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateDisciplineRecordUserDTO = UpdateDisciplineRecordUserDTO::validate($payloadArray);

        $disciplineRecord = DisciplineRecord::find($updateDisciplineRecordUserDTO['id']);
        if (! $disciplineRecord) {
            throw new \Exception('Discipline record not found');
        }
        if ($disciplineRecord->status !== 'Pending') {
            throw new \Exception('Only records with status Pending can be edited; use approve/reject for reviewed records.');
        }

        $misconductLevel = DisciplineMisconductLevel::find($updateDisciplineRecordUserDTO['misconduct_level_id']);
        if (! $misconductLevel) {
            throw new \Exception('Misconduct level not found');
        }

        $marksDeducted = $updateDisciplineRecordUserDTO['marks_deducted'];
        $outOfRange = $marksDeducted < $misconductLevel->indicative_deduction_min
            || $marksDeducted > $misconductLevel->indicative_deduction_max;
        if ($outOfRange && empty($updateDisciplineRecordUserDTO['override_reason'])) {
            throw new \Exception('marks_deducted is outside the selected level\'s indicative range ('.$misconductLevel->indicative_deduction_min.'-'.$misconductLevel->indicative_deduction_max.'); provide override_reason to proceed.');
        }

        // System Data Prep
        $system_data = [];
        $system_data['academic_year'] = DisciplineMarksCalculator::academicYearForDate(Carbon::parse($updateDisciplineRecordUserDTO['incident_date']));
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateDisciplineRecordSystemDTO = UpdateDisciplineRecordSystemDTO::validate($system_data);

        // Final Data Validation
        $updateDisciplineRecordDTO = UpdateDisciplineRecordDTO::validate(array_merge($updateDisciplineRecordUserDTO, $updateDisciplineRecordSystemDTO));

        DisciplineRecord::where('id', $updateDisciplineRecordUserDTO['id'])->update($updateDisciplineRecordDTO);

        return DisciplineRecord::find($updateDisciplineRecordUserDTO['id']);
    }
}
