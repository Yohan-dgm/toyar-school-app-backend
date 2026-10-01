<?php

namespace Modules\PurchasingManagement\Intents\Supplier\GetSupplierListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\Supplier;

class GetSupplierListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Supplier Data Validation
        $getSupplierListDataUserDTO = GetSupplierListDataUserDTO::validate($payloadArray);

        // Action
        $supplierListData = Supplier::where(function (Builder $supplier_query_group1) use ($getSupplierListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSupplierListDataUserDTO) && $getSupplierListDataUserDTO['group_filter'] != '') {
                if ($getSupplierListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $supplier_query_group2) use ($getSupplierListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSupplierListDataUserDTO) && ! is_null($getSupplierListDataUserDTO['search_filter_list']) && count($getSupplierListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSupplierListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $supplier_query_group3) use ($getSupplierListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSupplierListDataUserDTO) && $getSupplierListDataUserDTO['search_phrase'] != '') {
                $supplier_query_group3->where('name', 'ILIKE', '%'.$getSupplierListDataUserDTO['search_phrase'].'%');
                $supplier_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getSupplierListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['person_title' => function (Builder $person_title_query) {
                //
                $person_title_query->select('id', 'name');
            }])
            ->with(['country' => function (Builder $country_query) {
                //
                $country_query->select('id', 'name');
            }])
            ->select(
                'id',
                'serial_number',
                'supplier_type',
                'name',
                'person_title_id',
                'name_with_title',
                'phone',
                'email',
                'full_address',
                'country_id',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getSupplierListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSupplierListDataUserDTO['page']
            );

        return $supplierListData;
    }
}
