<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\GetMisconductLevelListData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineMisconductLevel;

class GetMisconductLevelListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getMisconductLevelListDataUserDTO = GetMisconductLevelListDataUserDTO::validate($payloadArray);

        $query = DisciplineMisconductLevel::query();

        if (empty($getMisconductLevelListDataUserDTO['include_inactive'])) {
            $query->where('is_active', true);
        }

        return $query->orderBy('level_number', 'asc')->get();
    }
}
