<?php

namespace Modules\AccountManagement\Intents\BankStatement\GetBankStatementListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\BankStatement;

class GetBankStatementListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // BankStatement Data Validation
        $getBankStatementListDataUserDTO = GetBankStatementListDataUserDTO::validate($payloadArray);

        // Action
        $bankStatement = BankStatement::where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
            // Handle group_filter
            if (array_key_exists('group_filter', $getBankStatementListDataUserDTO) && $getBankStatementListDataUserDTO['group_filter'] != '') {
                if ($getBankStatementListDataUserDTO['group_filter'] == 'Pending Reconcile') {
                    $bank_statement_group1->where('is_reconciled', false);
                } elseif ($getBankStatementListDataUserDTO['group_filter'] == 'Reconciled') {
                    $bank_statement_group1->where('is_reconciled', true);
                } elseif ($getBankStatementListDataUserDTO['group_filter'] == 'Withdrawal') {
                    $bank_statement_group1->where('transaction_type', 'Withdrawal');
                } else {
                    $bank_statement_group1->where('transaction_type', 'Deposit');
                }
            }
        })->where(function (Builder $bank_statement_group2) use ($getBankStatementListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'from_date' && $value != null) {
                        $bank_statement_group2->where('transaction_date', '>=', $value);
                    }
                    if ($key == 'to_date' && $value != null) {
                        $bank_statement_group2->where('transaction_date', '<=', $value);
                    }
                    if ($key == 'bank_account_id' && $value != null) {
                        if ($value != 0) {
                            $bank_statement_group2->where('bank_account_id', '=', $value);
                        }
                    }
                    if ($key == 'is_reconciled' && $value != null) {
                        $bank_statement_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $bank_statement_group3) use ($getBankStatementListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getBankStatementListDataUserDTO) && $getBankStatementListDataUserDTO['search_phrase'] != '') {
                $bank_statement_group3->where('transaction_reference_number', 'ILIKE', '%'.$getBankStatementListDataUserDTO['search_phrase'].'%');
                $bank_statement_group3->orWhere('transaction_details', 'ILIKE', '%'.$getBankStatementListDataUserDTO['search_phrase'].'%');
            }
        })->with(['bank_account' => function (Builder $bank_account_query) {
            $bank_account_query->select('id', 'name');
        }])
            ->select(
                'id',
                'bank_account_id',
                'transaction_date',
                'transaction_type',
                'amount',
                'transaction_reference_number',
                'transaction_details',
                'running_balance',
                'is_reconciled',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getBankStatementListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getBankStatementListDataUserDTO['page']
            );

        return $bankStatement;
    }
}
