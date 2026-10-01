<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\DeleteMisconductLevel;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;

class DeleteMisconductLevelAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteMisconductLevelUserDTO = DeleteMisconductLevelUserDTO::validate($payloadArray);

        $misconductLevel = DisciplineMisconductLevel::find($deleteMisconductLevelUserDTO['id']);
        if (! $misconductLevel) {
            throw new \Exception('Misconduct level not found');
        }

        // System Data Validation
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];
        $deleteMisconductLevelSystemDTO = DeleteMisconductLevelSystemDTO::validate($system_data);

        // Soft delete (deactivate) rather than hard delete - preserves history for records referencing it
        DisciplineMisconductLevel::where('id', $deleteMisconductLevelUserDTO['id'])->update([
            'is_active' => false,
            'updated_by' => $deleteMisconductLevelSystemDTO['updated_by'],
        ]);

        return DisciplineMisconductLevel::find($deleteMisconductLevelUserDTO['id']);
    }
}
