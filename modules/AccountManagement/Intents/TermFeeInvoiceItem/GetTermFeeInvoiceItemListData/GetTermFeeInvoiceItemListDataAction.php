<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\GetTermFeeInvoiceItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\TermFeeInvoiceItem;

class GetTermFeeInvoiceItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // TermFeeInvoiceItem Data Validation
        $getTermFeeInvoiceItemListDataUserDTO = GetTermFeeInvoiceItemListDataUserDTO::validate($payloadArray);

        // Action
        $term_fee_invoice_item = TermFeeInvoiceItem::where(function (Builder $term_fee_invoice_item_group1) use ($getTermFeeInvoiceItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getTermFeeInvoiceItemListDataUserDTO['group_filter']) && $getTermFeeInvoiceItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $term_fee_invoice_item_group2) use ($getTermFeeInvoiceItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getTermFeeInvoiceItemListDataUserDTO['search_filter_list'])) {
                foreach ($getTermFeeInvoiceItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'term_fee_invoice_id' && $value != null) {
                        $term_fee_invoice_item_group2->where('term_fee_invoice_id', $value);
                    }
                    // if ($key == 'item_type' && $value != null) {
                    //     $term_fee_invoice_item_group2->where('item_type', $value);
                    // }
                }
            }
        })->where(function (Builder $term_fee_invoice_item_group3) use ($getTermFeeInvoiceItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getTermFeeInvoiceItemListDataUserDTO) && $getTermFeeInvoiceItemListDataUserDTO['search_phrase'] != '') {
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
            'term_fee_invoice_id',
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
                $perPage = $getTermFeeInvoiceItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getTermFeeInvoiceItemListDataUserDTO['page']
            );

        return $term_fee_invoice_item;
    }
}
