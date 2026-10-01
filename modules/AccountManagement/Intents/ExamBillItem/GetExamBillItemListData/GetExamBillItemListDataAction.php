<?php

namespace Modules\AccountManagement\Intents\ExamBillItem\GetExamBillItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExamBillItem;

class GetExamBillItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExamBillItem Data Validation
        $getExamBillItemListDataUserDTO = GetExamBillItemListDataUserDTO::validate($payloadArray);

        // Action
        $exam_bill_item = ExamBillItem::where(function (Builder $exam_bill_item_group1) use ($getExamBillItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getExamBillItemListDataUserDTO['group_filter']) && $getExamBillItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $exam_bill_item_group2) use ($getExamBillItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getExamBillItemListDataUserDTO['search_filter_list'])) {
                foreach ($getExamBillItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_bill_item_group3) use ($getExamBillItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getExamBillItemListDataUserDTO) && $getExamBillItemListDataUserDTO['search_phrase'] != '') {
            }
        })
            ->select(
                'id',
                'exam_subject_category_id',
                'subtotal',
                'total',
                'created_at',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamBillItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamBillItemListDataUserDTO['page']
            );

        return $exam_bill_item;
    }
}
