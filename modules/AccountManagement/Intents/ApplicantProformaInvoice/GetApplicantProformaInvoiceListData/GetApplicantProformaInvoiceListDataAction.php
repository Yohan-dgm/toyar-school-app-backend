<?php

namespace Modules\AccountManagement\Intents\ApplicantProformaInvoice\GetApplicantProformaInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ApplicantProformaInvoice;

class GetApplicantProformaInvoiceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ApplicantProformaInvoice Data Validation
        $getApplicantProformaInvoiceListDataUserDTO = GetApplicantProformaInvoiceListDataUserDTO::validate($payloadArray);

        // Action
        $applicant_proforma_invoice = ApplicantProformaInvoice::where(function (Builder $applicant_proforma_invoice_group1) use ($getApplicantProformaInvoiceListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getApplicantProformaInvoiceListDataUserDTO) && $getApplicantProformaInvoiceListDataUserDTO['group_filter'] != '') {
                if ($getApplicantProformaInvoiceListDataUserDTO['group_filter'] == 'All') {
                    // $applicant_proforma_invoice_group1->where('is_active', true);
                } elseif ($getApplicantProformaInvoiceListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                    $applicant_proforma_invoice_group1->where('is_applicant_proforma_invoice_complete', true);
                    // $applicant_proforma_invoice_group1->whereNot('bill_total', 0);
                } elseif ($getApplicantProformaInvoiceListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                    $applicant_proforma_invoice_group1->where('is_applicant_proforma_invoice_complete', false);
                    // $applicant_proforma_invoice_group1->whereNot('bill_total', 0);
                }
            }
        })->where(function (Builder $applicant_proforma_invoice_group2) use ($getApplicantProformaInvoiceListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getApplicantProformaInvoiceListDataUserDTO['search_filter_list'])) {
                foreach ($getApplicantProformaInvoiceListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $applicant_proforma_invoice_group3) use ($getApplicantProformaInvoiceListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getApplicantProformaInvoiceListDataUserDTO) && $getApplicantProformaInvoiceListDataUserDTO['search_phrase'] != '') {

                $applicant_proforma_invoice_group3->where('serial_number', 'ILIKE', '%'.$getApplicantProformaInvoiceListDataUserDTO['search_phrase'].'%');

                $applicant_proforma_invoice_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getApplicantProformaInvoiceListDataUserDTO) {
                    return $applicant_query->where('full_name', 'ILIKE', '%'.$getApplicantProformaInvoiceListDataUserDTO['search_phrase'].'%')
                        ->orWhere('applicant_number', 'ILIKE', '%'.$getApplicantProformaInvoiceListDataUserDTO['search_phrase'].'%');
                });
                $applicant_proforma_invoice_group3->orWhereHas('receipt_voucher_list', function (Builder $receipt_voucher_list_query) use ($getApplicantProformaInvoiceListDataUserDTO) {
                    return $receipt_voucher_list_query->where('serial_number', 'ILIKE', '%'.$getApplicantProformaInvoiceListDataUserDTO['search_phrase'].'%');
                });

                // $applicant_proforma_invoice_group3->orWhereHas('applicant_proforma_invoice_item_list', function (Builder $applicant_proforma_invoice_item_list_query) use ($getApplicantProformaInvoiceListDataUserDTO) {
                //     return $applicant_proforma_invoice_item_list_query->where('print_description', "ILIKE", "%" . $getApplicantProformaInvoiceListDataUserDTO['search_phrase'] . "%");
                // });
            }
        })->where(function (Builder $applicant_proforma_invoice_group4) {
            // Handle date_filter
            // $applicant_proforma_invoice_group4->whereHas('receipt_voucher_list', function (Builder $receipt_voucher_list_query) use ($getApplicantProformaInvoiceListDataUserDTO) {
            //     return $receipt_voucher_list_query->where('is_active', true);
            // });

        })
            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->select('*');
            }])
            ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
                //
                $receipt_voucher_list_query->where('is_active', true);
                $receipt_voucher_list_query->with(['applicant' => function (Builder $applicant_query) {
                    //
                    $applicant_query->select('id', 'full_name_with_title', 'admission_number');
                }])
                    ->with(['applicant' => function (Builder $applicant_query) {
                        //
                        $applicant_query->select('id', 'full_name_with_title', 'applicant_number');
                    }])
                    ->with(['cash_account' => function (Builder $cash_account_query) {
                        //
                        $cash_account_query->select('id', 'name');
                    }])
                    ->with(['bank_account' => function (Builder $bank_account_query) {
                        //
                        $bank_account_query->select('id', 'name');
                    }])
                    ->with(['receipt_voucher_status_type' => function (Builder $receipt_voucher_status_type_query) {
                        //
                        $receipt_voucher_status_type_query->select('id', 'name');
                    }])
                    ->with(['receipt_voucher_attachment_list' => function (Builder $receipt_voucher_attachment_list_query) {
                        //
                        $receipt_voucher_attachment_list_query->select('*');
                    }])->select('*');
            }])
            ->with(['applicant_proforma_invoice_item_list' => function (Builder $applicant_proforma_invoice_item_list_query) {
                //
                $applicant_proforma_invoice_item_list_query->select(
                    'id',
                    'applicant_proforma_invoice_id',
                    'invoice_type',
                    'amount',
                    'print_invoice_type',
                    'print_amount',
                );
            }])
            ->select(
                'id',
                'date',
                'applicant_id',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                'tax_total',
                'bill_total',
                'order_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getApplicantProformaInvoiceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getApplicantProformaInvoiceListDataUserDTO['page']
            );

        return $applicant_proforma_invoice;
    }
}
