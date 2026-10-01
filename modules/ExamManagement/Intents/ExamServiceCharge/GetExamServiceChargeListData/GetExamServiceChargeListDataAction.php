<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\GetExamServiceChargeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamServiceCharge;

class GetExamServiceChargeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamServiceChargeListDataUserDTO = GetExamServiceChargeListDataUserDTO::validate($payloadArray);

        // Action
        $getExamServiceChargeListData = ExamServiceCharge::where(function (Builder $exam_service_charge_query_group1) use ($getExamServiceChargeListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamServiceChargeListDataUserDTO) && $getExamServiceChargeListDataUserDTO['group_filter'] != '') {
                if ($getExamServiceChargeListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $exam_service_charge_query_group2) {
            // search_filter_list
        })->where(function (Builder $exam_service_charge_query_group3) use ($getExamServiceChargeListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamServiceChargeListDataUserDTO) && $getExamServiceChargeListDataUserDTO['search_phrase'] != '') {
                $exam_service_charge_query_group3->where('name', 'ILIKE', '%'.$getExamServiceChargeListDataUserDTO['search_phrase'].'%');
                $exam_service_charge_query_group3->orWhere('exam_service_charge_amount', 'ILIKE', '%'.$getExamServiceChargeListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
                'exam_service_charge_amount',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getExamServiceChargeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamServiceChargeListDataUserDTO['page']
            );

        return $getExamServiceChargeListData;
    }
}
