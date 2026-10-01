<?php

namespace Modules\ProgramManagement\Intents\Subject\GetSubjectListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\Subject;

class GetSubjectListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Subject Data Validation
        $getSubjectListDataUserDTO = GetSubjectListDataUserDTO::validate($payloadArray);

        // Action
        $subjectListData = Subject::where(function (Builder $subject_query_group1) use ($getSubjectListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSubjectListDataUserDTO) && $getSubjectListDataUserDTO['group_filter'] != '') {
                if ($getSubjectListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $subject_query_group2) use ($getSubjectListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSubjectListDataUserDTO) && ! is_null($getSubjectListDataUserDTO['search_filter_list']) && count($getSubjectListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSubjectListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($value != null) {
                        $subject_query_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $subject_query_group3) use ($getSubjectListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSubjectListDataUserDTO) && $getSubjectListDataUserDTO['search_phrase'] != '') {
                $subject_query_group3->where('name', 'ILIKE', '%'.$getSubjectListDataUserDTO['search_phrase'].'%');
                $subject_query_group3->orWhere('subject_code', 'ILIKE', '%'.$getSubjectListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
                'program_id',
                'subject_code',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getSubjectListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSubjectListDataUserDTO['page']
            );

        return $subjectListData;
    }
}
