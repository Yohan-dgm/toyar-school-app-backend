<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\DeleteDisciplineRecord;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;

class DeleteDisciplineRecordAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteDisciplineRecordUserDTO = DeleteDisciplineRecordUserDTO::validate($payloadArray);

        $disciplineRecord = DisciplineRecord::find($deleteDisciplineRecordUserDTO['id']);
        if (! $disciplineRecord) {
            throw new \Exception('Discipline record not found');
        }

        // System Data Validation
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $deleteDisciplineRecordSystemDTO = DeleteDisciplineRecordSystemDTO::validate($system_data);

        // Soft delete - preserves history, never overwritten on academic-year rollover
        DisciplineRecord::where('id', $deleteDisciplineRecordUserDTO['id'])->update([
            'is_active' => false,
            'updated_by' => $deleteDisciplineRecordSystemDTO['updated_by'],
        ]);

        return DisciplineRecord::find($deleteDisciplineRecordUserDTO['id']);
    }
}
