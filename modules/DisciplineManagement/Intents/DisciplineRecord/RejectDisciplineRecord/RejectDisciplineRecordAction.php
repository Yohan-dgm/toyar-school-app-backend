<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\RejectDisciplineRecord;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;

class RejectDisciplineRecordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $rejectDisciplineRecordUserDTO = RejectDisciplineRecordUserDTO::validate($payloadArray);

        $disciplineRecord = DisciplineRecord::find($rejectDisciplineRecordUserDTO['id']);
        if (! $disciplineRecord) {
            throw new \Exception('Discipline record not found');
        }
        if ($disciplineRecord->status !== 'Pending') {
            throw new \Exception('Only records with status Pending can be rejected.');
        }

        // System Data Prep
        $system_data = [];
        $system_data['status'] = 'Rejected';
        $system_data['reviewed_by'] = $actionData['updated_by'];
        $system_data['reviewed_date'] = Carbon::now()->toDateString();
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $rejectDisciplineRecordSystemDTO = RejectDisciplineRecordSystemDTO::validate($system_data);

        // Final Data Validation
        $rejectDisciplineRecordDTO = RejectDisciplineRecordDTO::validate($rejectDisciplineRecordSystemDTO);

        DisciplineRecord::where('id', $rejectDisciplineRecordUserDTO['id'])->update($rejectDisciplineRecordDTO);

        return DisciplineRecord::find($rejectDisciplineRecordUserDTO['id']);
    }
}
