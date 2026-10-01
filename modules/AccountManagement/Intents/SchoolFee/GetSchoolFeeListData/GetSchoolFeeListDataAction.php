<?php

namespace Modules\AccountManagement\Intents\SchoolFee\GetSchoolFeeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SchoolFee;

class GetSchoolFeeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SchoolFee Data Validation
        $getSchoolFeeListDataUserDTO = GetSchoolFeeListDataUserDTO::validate($payloadArray);

        // Action
        $exam_bill_item = SchoolFee::where(function (Builder $exam_bill_item_group1) use ($getSchoolFeeListDataUserDTO) {
            // Handle group_filter
            if (! empty($getSchoolFeeListDataUserDTO['group_filter']) && $getSchoolFeeListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $exam_bill_item_group2) use ($getSchoolFeeListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getSchoolFeeListDataUserDTO['search_filter_list'])) {
                foreach ($getSchoolFeeListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_bill_item_group3) use ($getSchoolFeeListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getSchoolFeeListDataUserDTO) && $getSchoolFeeListDataUserDTO['search_phrase'] != '') {
            }
        })
            ->select(
                'id',
                'school_fee_type',
                'grade_level_id',
                'amount',
                'name',
                'created_at',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getSchoolFeeListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSchoolFeeListDataUserDTO['page']
            );

        return $exam_bill_item;
    }
}
