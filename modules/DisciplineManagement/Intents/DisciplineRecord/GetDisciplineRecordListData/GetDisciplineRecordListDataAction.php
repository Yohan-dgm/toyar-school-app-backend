<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineRecordListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\DisciplineManagement\Models\DisciplineRecord;

class GetDisciplineRecordListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getDisciplineRecordListDataUserDTO = GetDisciplineRecordListDataUserDTO::validate($payloadArray);

        $query = DisciplineRecord::where('is_active', true)
            ->with([
                'student' => function (Builder $studentQuery) {
                    $studentQuery->select('id', 'full_name', 'full_name_with_title', 'admission_number', 'grade_level_class_id');
                },
                'misconduct_level' => function (Builder $misconductLevelQuery) {
                    $misconductLevelQuery->select('id', 'level_number', 'level_name', 'approval_tier');
                },
                'reported_by_user' => function (Builder $userQuery) {
                    $userQuery->select('id', 'call_name_with_title');
                },
                'reviewed_by_user' => function (Builder $userQuery) {
                    $userQuery->select('id', 'call_name_with_title');
                },
            ]);

        if (! empty($getDisciplineRecordListDataUserDTO['grade_class_at_time'])) {
            $query->where('grade_class_at_time', $getDisciplineRecordListDataUserDTO['grade_class_at_time']);
        }

        if (! empty($getDisciplineRecordListDataUserDTO['academic_year'])) {
            $query->where('academic_year', $getDisciplineRecordListDataUserDTO['academic_year']);
        }

        if (! empty($getDisciplineRecordListDataUserDTO['status'])) {
            $query->where('status', $getDisciplineRecordListDataUserDTO['status']);
        }

        if (! empty($getDisciplineRecordListDataUserDTO['search_phrase'])) {
            $searchPhrase = $getDisciplineRecordListDataUserDTO['search_phrase'];
            $query->where(function (Builder $searchQuery) use ($searchPhrase) {
                $searchQuery->where('offence', 'ILIKE', '%'.$searchPhrase.'%')
                    ->orWhereHas('student', function (Builder $studentQuery) use ($searchPhrase) {
                        $studentQuery->where('full_name', 'ILIKE', '%'.$searchPhrase.'%')
                            ->orWhere('admission_number', 'ILIKE', '%'.$searchPhrase.'%');
                    });
            });
        }

        return $query->orderBy('incident_date', 'desc')
            ->paginate(
                $perPage = $getDisciplineRecordListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getDisciplineRecordListDataUserDTO['page']
            );
    }
}
