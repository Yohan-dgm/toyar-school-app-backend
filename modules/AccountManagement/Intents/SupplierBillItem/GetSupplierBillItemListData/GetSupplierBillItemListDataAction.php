<?php

namespace Modules\AccountManagement\Intents\SupplierBillItem\GetSupplierBillItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SupplierBillItem;

class GetSupplierBillItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SupplierBillItem Data Validation
        $getSupplierBillItemListDataUserDTO = GetSupplierBillItemListDataUserDTO::validate($payloadArray);

        // Action
        $supplier_bill_item = SupplierBillItem::where(function (Builder $supplier_bill_item_group1) use ($getSupplierBillItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getSupplierBillItemListDataUserDTO['group_filter']) && $getSupplierBillItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $supplier_bill_item_group2) use ($getSupplierBillItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getSupplierBillItemListDataUserDTO['search_filter_list'])) {
                foreach ($getSupplierBillItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $supplier_bill_item_group3) use ($getSupplierBillItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getSupplierBillItemListDataUserDTO) && $getSupplierBillItemListDataUserDTO['search_phrase'] != '') {
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
            'supplier_bill_id',
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
                $perPage = $getSupplierBillItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSupplierBillItemListDataUserDTO['page']
            );

        return $supplier_bill_item;
    }
}
