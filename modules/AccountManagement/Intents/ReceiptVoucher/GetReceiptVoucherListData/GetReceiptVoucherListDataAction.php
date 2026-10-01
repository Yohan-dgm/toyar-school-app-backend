<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ReceiptVoucher;

class GetReceiptVoucherListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getReceiptVoucherListDataUserDTO = GetReceiptVoucherListDataUserDTO::validate($payloadArray);

        // Action
        $receiptVoucherListData = ReceiptVoucher::where(function (Builder $receipt_voucher_query_group1) use ($getReceiptVoucherListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getReceiptVoucherListDataUserDTO) && $getReceiptVoucherListDataUserDTO['group_filter'] != '') {
                if ($getReceiptVoucherListDataUserDTO['group_filter'] == 'All') {
                    $receipt_voucher_query_group1->where('is_active', true);
                } elseif (
                    $getReceiptVoucherListDataUserDTO['group_filter'] == 'Bank Deposit' ||
                    $getReceiptVoucherListDataUserDTO['group_filter'] == 'Cash' ||
                    $getReceiptVoucherListDataUserDTO['group_filter'] == 'Check'
                ) {
                    $receipt_voucher_query_group1->where('payment_method', $getReceiptVoucherListDataUserDTO['group_filter']);
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'This Week') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->startOfWeek()->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->endOfWeek()->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'Previous Week') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->startOfWeek()->subWeeks(1)->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->endOfWeek()->subWeeks(1)->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'This Month') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->startOfMonth()->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->endOfMonth()->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'Previous Month') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->startOfMonth()->subMonths(1)->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->endOfMonth()->subMonths(1)->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == '3 Months') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->startOfMonth()->subMonths(2)->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->endOfMonth()->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'This Quarter') {
                    $receipt_voucher_query_group1->where('payment_received_date', '>=', Carbon::now()->firstOfQuarter()->toDateString())
                        ->where('payment_received_date', '<=', Carbon::now()->lastOfQuarter()->toDateString());
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'Delete Request') {
                    $receipt_voucher_query_group1->where('is_deleted_reqested', true)->where('is_active', true);
                } elseif ($getReceiptVoucherListDataUserDTO['group_filter'] == 'Deleted Receipt Voucher') {
                    $receipt_voucher_query_group1->where('is_active', false);
                } else {
                    $receipt_voucher_query_group1->whereHas('receipt_voucher_status_type', function (Builder $receipt_voucher_status_type_query) use ($getReceiptVoucherListDataUserDTO) {
                        return $receipt_voucher_status_type_query->where('name', '=', $getReceiptVoucherListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $receipt_voucher_query_group2) use ($getReceiptVoucherListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getReceiptVoucherListDataUserDTO) && ! is_null($getReceiptVoucherListDataUserDTO['search_filter_list']) && count($getReceiptVoucherListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getReceiptVoucherListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $receipt_voucher_query_group2->where('payment_received_date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $receipt_voucher_query_group2->where('payment_received_date', '<=', $value);
                    }
                    if ($key == 'payment_method' && $value != null) {
                        $receipt_voucher_query_group2->where('payment_method', $value);

                        $receipt_voucher_query_group2->whereNot(function (Builder $cash_deposit_item_list_query) {
                            $cash_deposit_item_list_query->whereHas(('cash_deposit_item_list'), function (Builder $cash_deposit_item_list_query) {
                                //     // return $cash_deposit_item_list_query->whereNot();
                            });
                        });
                    }
                    if ($key == 'is_reconciled' && $value != null) {
                        $receipt_voucher_query_group2->where('is_reconciled', $value);
                    }
                }
            }
        })->where(function (Builder $receipt_voucher_query_group3) use ($getReceiptVoucherListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getReceiptVoucherListDataUserDTO) && $getReceiptVoucherListDataUserDTO['search_phrase'] != '') {
                $receipt_voucher_query_group3->where('amount', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                $receipt_voucher_query_group3->orWhere('serial_number', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                $receipt_voucher_query_group3->orWhere('narration', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                $receipt_voucher_query_group3->orWhereHas('student', function (Builder $student_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $student_query
                        ->where('full_name', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%')
                        ->orWhere('admission_number', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                });
                $receipt_voucher_query_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $applicant_query
                        ->where('full_name', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%')
                        ->orWhere('applicant_number', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                });
                $receipt_voucher_query_group3->orWhereHas('exam_private_candidate', function (Builder $exam_private_candidate_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $exam_private_candidate_query
                        ->where('full_name', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%')
                        ->orWhere('exam_private_candidate_number', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                });
                $receipt_voucher_query_group3->orWhereHas('private_candidate', function (Builder $private_candidate_query) use ($getReceiptVoucherListDataUserDTO) {
                    return $private_candidate_query
                        ->where('full_name', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%')
                        ->orWhere('exam_private_candidate_number', 'ILIKE', '%'.$getReceiptVoucherListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['student' => function (Builder $student_query) {
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
            // ->with(['applicant' => function (Builder $applicant_query) {
            //     //
            //     $applicant_query->with(['carer_profile_list' => function (Builder $carer_profile_list_query) {
            //         //
            //         $carer_profile_list_query->select("carer_profile.id", "carer_profile.carer_type", "carer_profile.full_name", "carer_profile.phone");
            //     }])->select("id", "gender", "full_name");
            // }])
            ->with(['receipt_voucher_status_type' => function (Builder $receipt_voucher_status_type_query) {
                //
                $receipt_voucher_status_type_query->select('id', 'name');
            }])
            ->with(['receipt_voucher_attachment_list' => function (Builder $receipt_voucher_attachment_list_query) {
                //
                $receipt_voucher_attachment_list_query->select('id', 'receipt_voucher_id', 'file_name', 'original_file_name', 'mime_type');
            }])
            ->with(['request_delete_receipt_voucher_list' => function (Builder $request_delete_receipt_voucher_list_query) {
                //
                $request_delete_receipt_voucher_list_query->select('id', 'delete_reason', 'receipt_voucher_id');
            }])
            ->with(['request_delete_receipt_voucher' => function (Builder $request_delete_receipt_voucher_query) {
                //
                $request_delete_receipt_voucher_query->select('id', 'delete_reason');
            }])
            ->with('exam_bill')
            ->select(
                'id',
                'serial_number',
                'receipt_party',
                'student_id',
                'applicant_id',
                'exam_private_candidate_id',
                'private_candidate_id',
                'narration',
                'amount',
                'admission_fee_settlement',
                'refundable_deposit_settlement',
                'term_fee_settlement',
                'payment_method',
                'bank_account_id',
                'bank_deposit_date',
                'cash_account_id',
                'cash_received_date',
                'check_type',
                'check_bank_id',
                'check_number',
                'check_received_date',
                'check_date',
                'payment_received_by_id',
                'payment_received_date',
                'receipt_voucher_status_type_id',
                'old_bill_number',
                'receipt_voucher_type',
                'exam_bill_id',
                'material_bill_id',
                'admission_fee_invoice_id',
                'term_fee_invoice_id',
                'refundable_deposit_id',
                'sport_fee_invoice_id',

                'is_reconciliation_complete',
                'reconciliation_completed_at',
                'sport_fee',
                'late_fee_charges',
                'reconciled_by',
                'is_active',
                'is_deleted_reqested',
                'request_delete_receipt_voucher_id',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getReceiptVoucherListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getReceiptVoucherListDataUserDTO['page']
            );

        return $receiptVoucherListData;
    }
}
