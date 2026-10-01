<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\GetPurchaseOrderItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseOrderItem;

class GetPurchaseOrderItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // PurchaseOrderItem Data Validation
        $getPurchaseOrderItemListDataUserDTO = GetPurchaseOrderItemListDataUserDTO::validate($payloadArray);

        // Action
        $purchase_order_item = PurchaseOrderItem::where(function (Builder $purchase_order_item_group1) use ($getPurchaseOrderItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getPurchaseOrderItemListDataUserDTO['group_filter']) && $getPurchaseOrderItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $purchase_order_item_group2) use ($getPurchaseOrderItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getPurchaseOrderItemListDataUserDTO['search_filter_list'])) {
                foreach ($getPurchaseOrderItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'purchase_order_id' && $value != null) {
                        $purchase_order_item_group2->where('purchase_order_id', $value);
                    }
                    if ($key == 'item_type' && $value != null) {
                        $purchase_order_item_group2->where('item_type', $value);
                    }
                }
            }
        })->where(function (Builder $purchase_order_item_group3) use ($getPurchaseOrderItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getPurchaseOrderItemListDataUserDTO) && $getPurchaseOrderItemListDataUserDTO['search_phrase'] != '') {
            }
        })->with(['material_item' => function (Builder $material_item_query) {
            //
            $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                //
                $material_item_type_query->select('*');
            }])->with(['material_item_category' => function (Builder $material_item_category_query) {
                //
                $material_item_category_query->select('*');
            }])->with(['unit' => function (Builder $unit_query) {
                //
                $unit_query->select('*');
            }])->select('*');
        }])->select(
            'id',
            'purchase_order_id',
            'item_type',
            'material_item_id',
            'item_quantity',
            'print_description',
            'print_quantity',
            'print_unit',
            'ordered_quantity',
            'billed_quantity',
            'received_quantity',
        )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getPurchaseOrderItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPurchaseOrderItemListDataUserDTO['page']
            );

        return $purchase_order_item;
    }
}
