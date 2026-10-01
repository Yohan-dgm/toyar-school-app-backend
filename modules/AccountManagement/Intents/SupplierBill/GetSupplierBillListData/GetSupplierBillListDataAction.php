<?php

namespace Modules\AccountManagement\Intents\SupplierBill\GetSupplierBillListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SupplierBill;

class GetSupplierBillListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SupplierBill Data Validation
        $getSupplierBillListDataUserDTO = GetSupplierBillListDataUserDTO::validate($payloadArray);

        // Action
        $supplier_bill = SupplierBill::where(function (Builder $supplier_bill_group1) use ($getSupplierBillListDataUserDTO) {
            // Handle group_filter
            if (! empty($getSupplierBillListDataUserDTO['group_filter']) && $getSupplierBillListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $supplier_bill_group2) use ($getSupplierBillListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getSupplierBillListDataUserDTO['search_filter_list'])) {
                foreach ($getSupplierBillListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $supplier_bill_group3) use ($getSupplierBillListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getSupplierBillListDataUserDTO) && $getSupplierBillListDataUserDTO['search_phrase'] != '') {

                $supplier_bill_group3->orWhere('serial_number', 'ILIKE', '%'.$getSupplierBillListDataUserDTO['search_phrase'].'%');

                $supplier_bill_group3->orWhereHas('supplier', function (Builder $supplier_query) use ($getSupplierBillListDataUserDTO) {
                    return $supplier_query->where('name', 'ILIKE', '%'.$getSupplierBillListDataUserDTO['search_phrase'].'%');
                });

                $supplier_bill_group3->orWhereHas('supplier_bill_item_list', function (Builder $supplier_bill_item_list_query) use ($getSupplierBillListDataUserDTO) {
                    return $supplier_bill_item_list_query->where('print_description', 'ILIKE', '%'.$getSupplierBillListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['supplier_bill_item_list' => function (Builder $supplier_bill_item_list_query) {
                //
                $supplier_bill_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                    //
                    $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                    }])->select('*');
                }])->select('*');
            }])
            ->select(
                'id',
                'purchase_order_id',
                'date',
                'bill_reference_number',
                'items_total',
                'transport_charges_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                'tax_total',
                'bill_total',
                'office_notes',
                //
                'serial_number',
                //
                'is_supplier_bill_complete',
                'supplier_bill_status_id',
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getSupplierBillListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSupplierBillListDataUserDTO['page']
            );

        return $supplier_bill;
    }
}
