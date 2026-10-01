<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\ApproveDisciplineRecord;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;
use Modules\DisciplineManagement\Support\DisciplineParentNotifier;

class ApproveDisciplineRecordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $approveDisciplineRecordUserDTO = ApproveDisciplineRecordUserDTO::validate($payloadArray);

        $disciplineRecord = DisciplineRecord::find($approveDisciplineRecordUserDTO['id']);
        if (! $disciplineRecord) {
            throw new \Exception('Discipline record not found');
        }
        if ($disciplineRecord->status !== 'Pending') {
            throw new \Exception('Only records with status Pending can be approved.');
        }

        // System Data Prep
        $system_data = [];
        $system_data['status'] = 'Approved';
        $system_data['reviewed_by'] = $actionData['updated_by'];
        $system_data['reviewed_date'] = Carbon::now()->toDateString();
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $approveDisciplineRecordSystemDTO = ApproveDisciplineRecordSystemDTO::validate($system_data);

        // Final Data Validation
        $approveDisciplineRecordDTO = ApproveDisciplineRecordDTO::validate($approveDisciplineRecordSystemDTO);

        DisciplineRecord::where('id', $approveDisciplineRecordUserDTO['id'])->update($approveDisciplineRecordDTO);

        $updatedRecord = DisciplineRecord::find($approveDisciplineRecordUserDTO['id']);

        DisciplineParentNotifier::notify($updatedRecord);

        return $updatedRecord;
    }
}
