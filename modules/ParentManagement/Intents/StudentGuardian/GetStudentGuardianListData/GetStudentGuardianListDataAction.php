<?php

namespace Modules\ParentManagement\Intents\StudentGuardian\GetStudentGuardianListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;

class GetStudentGuardianListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // StudentGuardian Data Validation
        $getStudentGuardianListDataUserDTO = GetStudentGuardianListDataUserDTO::validate($payloadArray);

        // Action
        $studentGuardianListData = StudentGuardian::where(function (Builder $studentGuardian_query_group1) use ($getStudentGuardianListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentGuardianListDataUserDTO) && $getStudentGuardianListDataUserDTO['group_filter'] != '') {
                if ($getStudentGuardianListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $studentGuardian_query_group2) use ($getStudentGuardianListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentGuardianListDataUserDTO) && ! is_null($getStudentGuardianListDataUserDTO['search_filter_list']) && count($getStudentGuardianListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentGuardianListDataUserDTO['search_filter_list'] as $key => $value) {
                    $studentGuardian_query_group2->where($key, $value);
                }
            }
        })->where(function (Builder $studentGuardian_query_group3) use ($getStudentGuardianListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentGuardianListDataUserDTO) && $getStudentGuardianListDataUserDTO['search_phrase'] != '') {
                $studentGuardian_query_group3->where('full_name', 'ILIKE', '%'.$getStudentGuardianListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'full_name',
                'id_type',
                'nic_number',
                'passport_number',
                'phone',
                'whatsapp',
                'email',
                'occupation',
                'place_of_work',
                'monthly_income',
                'guardian_type',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getStudentGuardianListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentGuardianListDataUserDTO['page']
            );

        return $studentGuardianListData;
    }
}
