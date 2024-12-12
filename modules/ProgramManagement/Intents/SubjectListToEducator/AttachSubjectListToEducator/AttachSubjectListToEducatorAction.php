<?php

namespace Modules\ProgramManagement\Intents\SubjectListToEducator\AttachSubjectListToEducator;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorManagement\Models\Educator;
use Modules\ProgramManagement\Models\SubjectListToEducator;

class AttachSubjectListToEducatorAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $attachSubjectListToEducatorUserDTO = AttachSubjectListToEducatorUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // Final Data Validation
        $attachSubjectListToEducatorDTO = AttachSubjectListToEducatorDTO::validate(array_merge($attachSubjectListToEducatorUserDTO, $system_data));

        // Save In Database
        // $subjectListToEducator = SubjectListToEducator::create($AttachSubjectListToEducatorDTO);
        $educator = Educator::where(function (Builder $educator_query) use ($attachSubjectListToEducatorDTO) {
            $educator_query->where("id", "=", "" . $attachSubjectListToEducatorDTO['educator_id'] . "");
        })->first();

        $attachData = [];
        $attachData['created_by'] = $actionData['created_by'];
        $educator->subject_list($attachSubjectListToEducatorDTO['educator_id'])->attach($attachSubjectListToEducatorDTO['subject_list'], $attachData);
        return true;
    }
}
