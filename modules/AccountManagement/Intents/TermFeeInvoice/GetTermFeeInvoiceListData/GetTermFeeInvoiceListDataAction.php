<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\GetTermFeeInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\TermFeeInvoice;

class GetTermFeeInvoiceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // TermFeeInvoice Data Validation
        $getTermFeeInvoiceListDataUserDTO = GetTermFeeInvoiceListDataUserDTO::validate($payloadArray);

        // Action
        $term_fee_invoice = TermFeeInvoice::where(function (Builder $term_fee_invoice_group1) use ($getTermFeeInvoiceListDataUserDTO) {
            // Handle group_filter
            if ($getTermFeeInvoiceListDataUserDTO['group_filter'] == 'All') {
            } elseif ($getTermFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Completed Invoices') {
                $term_fee_invoice_group1->where('is_term_fee_invoice_complete', true);
                $term_fee_invoice_group1->whereNot('bill_total', 0);
            } elseif ($getTermFeeInvoiceListDataUserDTO['group_filter'] == 'Payment Due Invoices') {
                $term_fee_invoice_group1->where('is_term_fee_invoice_complete', false);
                $term_fee_invoice_group1->whereNot('bill_total', 0);
            } elseif ($getTermFeeInvoiceListDataUserDTO['group_filter'] == 'Free Term Fee Invoices') {
                $term_fee_invoice_group1->where('bill_total', 0);
            } else {
                $term_fee_invoice_group1->whereHas('term', function (Builder $term_fee_invoice_group2) use ($getTermFeeInvoiceListDataUserDTO) {
                    return $term_fee_invoice_group2->where('name', $getTermFeeInvoiceListDataUserDTO['group_filter']);
                });
            }
        })->where(function (Builder $term_fee_invoice_group2) use ($getTermFeeInvoiceListDataUserDTO) {
            // Handle search_filter_list
            if (array_key_exists('search_filter_list', $getTermFeeInvoiceListDataUserDTO) && ! is_null($getTermFeeInvoiceListDataUserDTO['search_filter_list']) && count($getTermFeeInvoiceListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getTermFeeInvoiceListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $term_fee_invoice_group2->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $term_fee_invoice_group2->where('date', '<=', $value);
                    }
                    if ($value != null) {
                        $term_fee_invoice_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $term_fee_invoice_group3) use ($getTermFeeInvoiceListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getTermFeeInvoiceListDataUserDTO) && $getTermFeeInvoiceListDataUserDTO['search_phrase'] != '') {

                $term_fee_invoice_group3->where('serial_number', 'ILIKE', '%'.$getTermFeeInvoiceListDataUserDTO['search_phrase'].'%');

                $term_fee_invoice_group3->orWhereHas('student', function (Builder $student_query) use ($getTermFeeInvoiceListDataUserDTO) {
                    return $student_query->where('full_name', 'ILIKE', '%'.$getTermFeeInvoiceListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getTermFeeInvoiceListDataUserDTO['search_phrase'].'%');
                });
            }
        })->where('student_id', $getTermFeeInvoiceListDataUserDTO['student_id'])
            //
            ->with(['student' => function (Builder $student_query) {
                //
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
            ->with(['term_fee_payment_list' => function (Builder $term_fee_payment_list_query) {
                $term_fee_payment_list_query->with(['receipt_voucher' => function (Builder $receipt_voucher_query) {
                    //
                    $receipt_voucher_query->with(['receipt_voucher_attachment_list' => function (Builder $receipt_voucher_attachment_list_query) {
                        //
                        $receipt_voucher_attachment_list_query->select('*');
                    }])->select('*');
                    $receipt_voucher_query->select('*');
                }]);
                $term_fee_payment_list_query->select('*');
            }])
            ->with(['term_fee_invoice_item_list' => function (Builder $term_fee_invoice_item_list_query) {
                //
                $term_fee_invoice_item_list_query->with(['grade_level' => function (Builder $grade_level_query) {
                    //
                    $grade_level_query->select('*');
                }])->with(['school_fee' => function (Builder $school_fee_query) {
                    //
                    $school_fee_query->select('*');
                }])->with(['term' => function (Builder $term_query) {
                    //
                    $term_query->select('*');
                }])
                    ->select(
                        'id',
                        'term_fee_invoice_id',
                        'grade_level_id',
                        'term_id',
                        'school_fee_id',
                        'item_total',
                    );
            }])
            ->select(
                'id',
                'date',
                'term_id',
                'student_id',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'discount_total',
                'subtotal_after_discount',
                'bill_total',
                'order_notes',
                'office_notes',
                'serial_number'
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getTermFeeInvoiceListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getTermFeeInvoiceListDataUserDTO['page']
            );

        return $term_fee_invoice;
    }
}
