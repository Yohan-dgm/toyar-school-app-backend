<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\GetAdmissionFeeInvoiceItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoiceItem;

class GetAdmissionFeeInvoiceItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // AdmissionFeeInvoiceItem Data Validation
        $getAdmissionFeeInvoiceItemListDataUserDTO = GetAdmissionFeeInvoiceItemListDataUserDTO::validate($payloadArray);

        // Action
        $admission_fee_invoice_item = AdmissionFeeInvoiceItem::where(function (Builder $admission_fee_invoice_item_group1) use ($getAdmissionFeeInvoiceItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getAdmissionFeeInvoiceItemListDataUserDTO['group_filter']) && $getAdmissionFeeInvoiceItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $admission_fee_invoice_item_group2) use ($getAdmissionFeeInvoiceItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getAdmissionFeeInvoiceItemListDataUserDTO['search_filter_list'])) {
                foreach ($getAdmissionFeeInvoiceItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'admission_fee_invoice_id' && $value != null) {
                        $admission_fee_invoice_item_group2->where('admission_fee_invoice_id', $value);
                    }
                    if ($key == 'item_type' && $value != null) {
                        $admission_fee_invoice_item_group2->where('item_type', $value);
                    }
                }
            }
        })->where(function (Builder $admission_fee_invoice_item_group3) use ($getAdmissionFeeInvoiceItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getAdmissionFeeInvoiceItemListDataUserDTO) && $getAdmissionFeeInvoiceItemListDataUserDTO['search_phrase'] != '') {
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
                'admission_fee_invoice_id',
                'school_fee_id',
                'description',
                'is_admission_fee_invoice_item_complete',
                'item_total',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getAdmissionFeeInvoiceItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getAdmissionFeeInvoiceItemListDataUserDTO['page']
            );

        return $admission_fee_invoice_item;
    }
}
