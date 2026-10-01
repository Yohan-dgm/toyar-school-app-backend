<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\GetMaterialItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItem;

class GetMaterialItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // MaterialItem Data Validation
        $getMaterialItemListDataUserDTO = GetMaterialItemListDataUserDTO::validate($payloadArray);

        // Action
        $materialItemListData = MaterialItem::where(function (Builder $material_item_query_group1) use ($getMaterialItemListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getMaterialItemListDataUserDTO) && $getMaterialItemListDataUserDTO['group_filter'] != '') {
                if ($getMaterialItemListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $material_item_query_group1->whereHas('material_item_type', function (Builder $material_item_type_query) use ($getMaterialItemListDataUserDTO) {
                        return $material_item_type_query->where('name', '=', $getMaterialItemListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $MaterialItem_query_group2) use ($getMaterialItemListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getMaterialItemListDataUserDTO) && ! is_null($getMaterialItemListDataUserDTO['search_filter_list']) && count($getMaterialItemListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getMaterialItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $material_item_query_group3) use ($getMaterialItemListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getMaterialItemListDataUserDTO) && $getMaterialItemListDataUserDTO['search_phrase'] != '') {
                $material_item_query_group3->where('name', 'ILIKE', '%'.$getMaterialItemListDataUserDTO['search_phrase'].'%');

                $material_item_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getMaterialItemListDataUserDTO['search_phrase'].'%');

                $material_item_query_group3->orWhereHas('material_item_category', function (Builder $material_item_category_query) use ($getMaterialItemListDataUserDTO) {
                    return $material_item_category_query->where('name', 'ILIKE', '%'.$getMaterialItemListDataUserDTO['search_phrase'].'%');
                });

                $material_item_query_group3->orWhereHas('unit', function (Builder $unit_query) use ($getMaterialItemListDataUserDTO) {
                    return $unit_query->where('name', 'ILIKE', '%'.$getMaterialItemListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where(function (Builder $MaterialItem_query_group4) {
            //
            $MaterialItem_query_group4->where('is_active', 1);
        })
            ->with(['material_item_type' => function (Builder $material_item_type_query) {
                //
                $material_item_type_query->select('id', 'name');
            }])

            ->with(['material_item_category' => function (Builder $material_item_category_query) {
                //
                $material_item_category_query->select('id', 'name');
            }])
            ->with(['unit' => function (Builder $unit_query) {
                //
                $unit_query->select('id', 'name');
            }])
            ->with(['inventory_item_list' => function (Builder $inventory_item_list_query) {
                //
                $inventory_item_list_query->select('id', 'material_item_id', 'current_quantity');
            }])
            ->select(
                'id',
                'serial_number',
                'name',
                'is_expirable',
                'reorder_level',
                'material_item_type_id',
                'material_item_category_id',
                'unit_id',
                'unit_price'
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getMaterialItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getMaterialItemListDataUserDTO['page']
            );

        return $materialItemListData;
    }
}
