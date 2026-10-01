<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\CreateSectionalHead;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\SectionalHead;

class CreateSectionalHeadAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createSectionalHeadUserDTO = CreateSectionalHeadUserDTO::validate($payloadArray);

        // Prepare data for creation
        $data = [
            'user_id' => $createSectionalHeadUserDTO['user_id'],
            'grade_level_id' => $createSectionalHeadUserDTO['grade_level_id'],
            'academic_year' => $createSectionalHeadUserDTO['academic_year'],
            'start_date' => $createSectionalHeadUserDTO['start_date'],
            'end_date' => $createSectionalHeadUserDTO['end_date'] ?? null,
            'is_active' => true,
            'created_by' => $actionData['created_by'],
        ];

        // Create sectional head assignment
        $sectionalHead = SectionalHead::create($data);

        // Load relationships for response
        $sectionalHead->load(['user', 'grade_level']);

        return $sectionalHead;
    }
}
