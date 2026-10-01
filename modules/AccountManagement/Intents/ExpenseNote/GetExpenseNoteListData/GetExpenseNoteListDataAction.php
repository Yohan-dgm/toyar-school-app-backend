<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\GetExpenseNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;

class GetExpenseNoteListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ExpenseNote Data Validation
        $getExpenseNoteListDataUserDTO = GetExpenseNoteListDataUserDTO::validate($payloadArray);

        // Action
        $expenseNoteListData = ExpenseNote::where(function (Builder $expenseNote_query_group1) use ($getExpenseNoteListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExpenseNoteListDataUserDTO) && $getExpenseNoteListDataUserDTO['group_filter'] != '') {
                if ($getExpenseNoteListDataUserDTO['group_filter'] == 'All') {
                    $expenseNote_query_group1->where('is_active', true);
                } elseif ($getExpenseNoteListDataUserDTO['group_filter'] == 'Payment Due Expense') {
                    $expenseNote_query_group1->where('is_active', true);
                    $expenseNote_query_group1->where('is_expense_note_complete', false);
                } elseif ($getExpenseNoteListDataUserDTO['group_filter'] == 'Payment Completed Expense') {
                    $expenseNote_query_group1->where('is_active', true);
                    $expenseNote_query_group1->where('is_expense_note_complete', true);
                } else {
                    $expenseNote_query_group1->whereHas('expense_type', function (Builder $expense_type_query) use ($getExpenseNoteListDataUserDTO) {
                        return $expense_type_query->where('name', '=', $getExpenseNoteListDataUserDTO['group_filter']);
                    });
                }
            }
        })->where(function (Builder $expenseNote_query_group2) use ($getExpenseNoteListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExpenseNoteListDataUserDTO) && ! is_null($getExpenseNoteListDataUserDTO['search_filter_list']) && count($getExpenseNoteListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExpenseNoteListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $expenseNote_query_group2->where('date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $expenseNote_query_group2->where('date', '<=', $value);
                    }
                    $expenseNote_query_group2->where('is_active', true);
                }
            }
        })->where(function (Builder $expenseNote_query_group3) use ($getExpenseNoteListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExpenseNoteListDataUserDTO) && $getExpenseNoteListDataUserDTO['search_phrase'] != '') {
                $expenseNote_query_group3->where('serial_number', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                $expenseNote_query_group3->orWhere('amount', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                $expenseNote_query_group3->orWhere('general_expense_party_info', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');

                $expenseNote_query_group3->orWhereHas('payment_voucher_list', function (Builder $payment_voucher_list_query) use ($getExpenseNoteListDataUserDTO) {
                    return $payment_voucher_list_query->where('serial_number', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                });
                $expenseNote_query_group3->orWhereHas('expense_party', function (Builder $expense_party_query) use ($getExpenseNoteListDataUserDTO) {
                    return $expense_party_query->where('name', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%')
                        ->orWhere('name_with_title', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                });
                $expenseNote_query_group3->orWhereHas('expense_type', function (Builder $expense_type_query) use ($getExpenseNoteListDataUserDTO) {
                    return $expense_type_query->where('name', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                });
                $expenseNote_query_group3->orWhereHas('expense_category', function (Builder $expense_category_query) use ($getExpenseNoteListDataUserDTO) {
                    return $expense_category_query->where('name', 'ILIKE', '%'.$getExpenseNoteListDataUserDTO['search_phrase'].'%');
                });
            }
        })->with(['expense_party' => function (Builder $expense_party_query) {
            //
            $expense_party_query->select('*');
        }])->with(['expense_type' => function (Builder $expense_type_query) {
            //
            $expense_type_query->select('*');
        }])->with(['expense_category' => function (Builder $expense_category_query) {
            //
            $expense_category_query->select('*');
        }])->with(['payment_voucher_list' => function (Builder $payment_voucher_list_query) {
            //
            $payment_voucher_list_query->where('is_active', true);
            $payment_voucher_list_query->with(['cash_account' => function (Builder $cash_account_query) {
                //
                $cash_account_query->select('*');
            }])->with(['bank_account' => function (Builder $bank_account_query) {
                //
                $bank_account_query->select('*');
            }])->with(['check_bank_account' => function (Builder $check_bank_account_query) {
                //
                $check_bank_account_query->select('*');
            }])->with(['payment_issued_by' => function (Builder $payment_issued_by_query) {
                //
                $payment_issued_by_query->select('*');
            }])->with(['purchase_order' => function (Builder $purchase_order_query) {
                //
                $purchase_order_query->select('*');
            }])->with(['expense_note' => function (Builder $expense_note_query) {
                //
                $expense_note_query->select('*');
            }])->select('*');
        }])->select(
            'id',
            'date',
            'expense_party_id',
            'general_expense_party_info',
            'expense_type_id',
            'expense_category_id',
            'amount',
            'office_notes',
            //
            'serial_number',
            'is_expense_note_complete',
            'expense_note_status_id',
            'created_by',
            'is_active',
            'updated_by',
        )
            ->orderBy('id', 'DESC')
            ->paginate(
                $perPage = $getExpenseNoteListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExpenseNoteListDataUserDTO['page']
            );

        return $expenseNoteListData;
    }
}
