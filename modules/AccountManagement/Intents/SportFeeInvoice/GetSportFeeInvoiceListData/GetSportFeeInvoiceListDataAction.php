<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\GetSportFeeInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SportFeeInvoice;

class GetSportFeeInvoiceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SportFeeInvoice Data Validation
        $getSportFeeInvoiceListDataUserDTO = GetSportFeeInvoiceListDataUserDTO::validate($payloadArray);

        // Action
        $sport_fee_invoice = SportFeeInvoice::where(function (Builder $sport_fee_invoice_group1) use ($getSportFeeInvoiceListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getSportFeeInvoiceListDataUserDTO) && $getSportFeeInvoiceListDataUserDTO['group_filter'] != '') {
                if ($getSportFeeInvoiceListDataUserDTO['group_filter'] == 'All') {
                } elseif ($getSportFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                    $sport_fee_invoice_group1->where('is_sport_fee_invoice_complete', true);
                    $sport_fee_invoice_group1->whereNot('bill_total', 0);
                } elseif ($getSportFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                    $sport_fee_invoice_group1->where('is_sport_fee_invoice_complete', false);
                    $sport_fee_invoice_group1->whereNot('bill_total', 0);
                }
            }
        })->where(function (Builder $sport_fee_invoice_group2) use ($getSportFeeInvoiceListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getSportFeeInvoiceListDataUserDTO['search_filter_list'])) {
                foreach ($getSportFeeInvoiceListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($value != null) {
                        $sport_fee_invoice_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $sport_fee_invoice_group3) use ($getSportFeeInvoiceListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getSportFeeInvoiceListDataUserDTO) && $getSportFeeInvoiceListDataUserDTO['search_phrase'] != '') {

                $sport_fee_invoice_group3->where('serial_number', 'ILIKE', '%'.$getSportFeeInvoiceListDataUserDTO['search_phrase'].'%');

                $sport_fee_invoice_group3->orWhereHas('student', function (Builder $student_query) use ($getSportFeeInvoiceListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getSportFeeInvoiceListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getSportFeeInvoiceListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where('student_id', $getSportFeeInvoiceListDataUserDTO['student_id'])
            //
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                        //
                        $school_fee_list_query->select('*');
                    }]);
                    $grade_level_query->select('*');
                }]);
                $student_query->select('*');
            }])
            ->with(['term' => function (Builder $term_query) {
                //
                $term_query->select('*');
            }])
            ->with(['receipt_voucher_list' => function (Builder $receipt_voucher_list_query) {
                //
                $receipt_voucher_list_query->where('is_active', true);
                $receipt_voucher_list_query->with(['student' => function (Builder $student_query) {
                    //
                    $student_query->select('id', 'full_name_with_title', 'admission_number');
                }])
                    ->with(['applicant' => function (Builder $applicant_query) {
                        //
                        $applicant_query->select('id', 'full_name_with_title', 'applicant_number');
                    }])
                    ->with(['exam_private_candidate' => function (Builder $exam_private_candidate_query) {
                        //
                        $exam_private_candidate_query->select('id', 'full_name_with_title', 'exam_private_candidate_number');
                    }])
                    ->with(['private_candidate' => function (Builder $private_candidate_query) {
                        //
                        $private_candidate_query->select('id', 'full_name_with_title', 'exam_private_candidate_number');
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
            ->with(['sport_fee_invoice_item_list' => function (Builder $sport_fee_invoice_item_list_query) {
                //
                $sport_fee_invoice_item_list_query->select(
                    'id',
                    'sport_fee_invoice_id',
                    'school_fee_id',
                    'description',
                    'is_sport_fee_invoice_item_complete',
                    'unit_price',
                    'qty',
                    'item_total',
                );
            }])
            ->select(
                'id',
                'date',
                'student_id',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                'tax_total',
                'bill_total',
                'order_notes',
                'office_notes',
                'serial_number',
                'term_id'
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getSportFeeInvoiceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSportFeeInvoiceListDataUserDTO['page']
            );

        return $sport_fee_invoice;
    }
}
