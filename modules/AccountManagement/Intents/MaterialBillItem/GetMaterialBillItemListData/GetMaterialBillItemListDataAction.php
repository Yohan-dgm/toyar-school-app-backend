<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\GetMaterialBillItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\MaterialBillItem;

class GetMaterialBillItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialBillItem Data Validation
        $getMaterialBillItemListDataUserDTO = GetMaterialBillItemListDataUserDTO::validate($payloadArray);

        // Action
        $material_bill_item = MaterialBillItem::where(function (Builder $material_bill_item_group1) use ($getMaterialBillItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getMaterialBillItemListDataUserDTO['group_filter']) && $getMaterialBillItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $material_bill_item_group2) use ($getMaterialBillItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getMaterialBillItemListDataUserDTO['search_filter_list'])) {
                foreach ($getMaterialBillItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'material_bill_id' && $value != null) {
                        $material_bill_item_group2->where('material_bill_id', $value);
                    }
                    if ($key == 'item_type' && $value != null) {
                        $material_bill_item_group2->where('item_type', $value);
                    }
                }
            }
        })->where(function (Builder $material_bill_item_group3) use ($getMaterialBillItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getMaterialBillItemListDataUserDTO) && $getMaterialBillItemListDataUserDTO['search_phrase'] != '') {
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
            'material_bill_id',
            'material_item_id',
            'item_quantity',
            'print_description',
            'print_quantity',
            'print_unit',
            'ordered_quantity',
            'billed_quantity',
            'unit_price',
            'item_total',
            'issued_quantity',
        )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getMaterialBillItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialBillItemListDataUserDTO['page']
            );

        return $material_bill_item;
    }
}
