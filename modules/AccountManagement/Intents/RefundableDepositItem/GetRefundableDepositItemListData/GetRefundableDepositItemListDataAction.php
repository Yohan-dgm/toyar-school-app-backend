<?php

namespace Modules\AccountManagement\Intents\RefundableDepositItem\GetRefundableDepositItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\RefundableDepositItem;

class GetRefundableDepositItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // RefundableDepositItem Data Validation
        $getRefundableDepositItemListDataUserDTO = GetRefundableDepositItemListDataUserDTO::validate($payloadArray);

        // Action
        $refundable_deposit_item = RefundableDepositItem::where(function (Builder $refundable_deposit_item_group1) use ($getRefundableDepositItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getRefundableDepositItemListDataUserDTO['group_filter']) && $getRefundableDepositItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $refundable_deposit_item_group2) use ($getRefundableDepositItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getRefundableDepositItemListDataUserDTO['search_filter_list'])) {
                foreach ($getRefundableDepositItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'refundable_deposit_id' && $value != null) {
                        $refundable_deposit_item_group2->where('refundable_deposit_id', $value);
                    }
                    if ($key == 'item_type' && $value != null) {
                        $refundable_deposit_item_group2->where('item_type', $value);
                    }
                }
            }
        })->where(function (Builder $refundable_deposit_item_group3) use ($getRefundableDepositItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getRefundableDepositItemListDataUserDTO) && $getRefundableDepositItemListDataUserDTO['search_phrase'] != '') {
            }
        })
            // ->with(['school_fee' => function (Builder $school_fee_query) {
            //     //
            //     $school_fee_query->with(['material_item_type' => function (Builder $material_item_type_query) {
            //         //
            //         $material_item_type_query->select("*");
            //     }])->with(['material_item_category' => function (Builder $material_item_category_query) {
            //         //
            //         $material_item_category_query->select("*");
            //     }])->with(['unit' => function (Builder $unit_query) {
            //         //
            //         $unit_query->select("*");
            //     }])->select("*");
            // }])
            ->select(
                'id',
                'refundable_deposit_id',
                'school_fee_id',
                'description',
                'is_refundable_deposit_item_complete',
                'item_total',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getRefundableDepositItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getRefundableDepositItemListDataUserDTO['page']
            );

        return $refundable_deposit_item;
    }
}
