<?php

namespace Modules\StudentManagement\Intents\StudentSport\GetStudentSportListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetStudentSportListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentSport Data Validation
        $getStudentSportListDataUserDTO = GetStudentSportListDataUserDTO::validate($payloadArray);

        // Action
        $studentSportListData = Student::where(function (Builder $studentSport_query_group1) use ($getStudentSportListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentSportListDataUserDTO) && $getStudentSportListDataUserDTO['group_filter'] != '') {
                if ($getStudentSportListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $studentSport_query_group2) use ($getStudentSportListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentSportListDataUserDTO) && ! is_null($getStudentSportListDataUserDTO['search_filter_list']) && count($getStudentSportListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentSportListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $studentSport_query_group3) use ($getStudentSportListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentSportListDataUserDTO) && $getStudentSportListDataUserDTO['search_phrase'] != '') {
                $studentSport_query_group3->where('name', 'ILIKE', '%'.$getStudentSportListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'full_name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getStudentSportListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentSportListDataUserDTO['page']
            );

        return $studentSportListData;
    }
}
