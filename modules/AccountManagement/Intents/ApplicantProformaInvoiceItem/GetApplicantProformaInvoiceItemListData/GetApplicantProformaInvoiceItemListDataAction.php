<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoiceItem\GetApplicantProformaInvoiceItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ApplicantProformaInvoiceItem;

class GetApplicantProformaInvoiceItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ApplicantProformaInvoiceItem Data Validation
        $getApplicantProformaInvoiceItemListDataUserDTO = GetApplicantProformaInvoiceItemListDataUserDTO::validate($payloadArray);

        // Action
        $applicant_proforma_invoice_item = ApplicantProformaInvoiceItem::where(function (Builder $applicant_proforma_invoice_item_group1) use ($getApplicantProformaInvoiceItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getApplicantProformaInvoiceItemListDataUserDTO['group_filter']) && $getApplicantProformaInvoiceItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $applicant_proforma_invoice_item_group2) use ($getApplicantProformaInvoiceItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getApplicantProformaInvoiceItemListDataUserDTO['search_filter_list'])) {
                foreach ($getApplicantProformaInvoiceItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'applicant_proforma_invoice_id' && $value != null) {
                        $applicant_proforma_invoice_item_group2->where('applicant_proforma_invoice_id', $value);
                    }
                    if ($key == 'item_type' && $value != null) {
                        $applicant_proforma_invoice_item_group2->where('item_type', $value);
                    }
                }
            }
        })->where(function (Builder $applicant_proforma_invoice_item_group3) use ($getApplicantProformaInvoiceItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getApplicantProformaInvoiceItemListDataUserDTO) && $getApplicantProformaInvoiceItemListDataUserDTO['search_phrase'] != '') {
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
            'applicant_proforma_invoice_id',
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
                $perPage = $getApplicantProformaInvoiceItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getApplicantProformaInvoiceItemListDataUserDTO['page']
            );

        return $applicant_proforma_invoice_item;
    }
}
