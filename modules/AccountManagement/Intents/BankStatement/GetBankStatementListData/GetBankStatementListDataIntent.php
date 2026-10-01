<?php

namespace Modules\AccountManagement\Intents\BankStatement\GetBankStatementListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\BankStatement;

class GetBankStatementListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // BankStatement Data Validation
            $getBankStatementListDataUserDTO = GetBankStatementListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $bankStatement = GetBankStatementListDataAction::run($getBankStatementListDataUserDTO, $actionData);
            $data['bank_statement_count'] = DB::table('bank_statement')->count();

            $data['pending_reconcile_bank_statement_count'] = BankStatement::where('is_reconciled', false)->where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
                // Handle search_filter_list
                if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                    foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '<=', $value);
                        }
                        if ($key == 'bank_account_id' && $value != null) {
                            if ($value != 0) {
                                $bank_statement_group1->where('bank_account_id', '=', $value);
                            }
                        }
                        if ($key == 'is_reconciled' && $value != null) {
                            $bank_statement_group1->where($key, $value);
                        }
                    }
                }
            })->count();
            $data['reconciled_bank_statement_count'] = BankStatement::where('is_reconciled', true)->where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
                // Handle search_filter_list
                if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                    foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '<=', $value);
                        }
                        if ($key == 'bank_account_id' && $value != null) {
                            if ($value != 0) {
                                $bank_statement_group1->where('bank_account_id', '=', $value);
                            }
                        }
                        if ($key == 'is_reconciled' && $value != null) {
                            $bank_statement_group1->where($key, $value);
                        }
                    }
                }
            })->count();
            $data['pending_reconcile_bank_statement_total_amount'] = BankStatement::where('is_reconciled', false)->where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
                // Handle search_filter_list
                if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                    foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '<=', $value);
                        }
                        if ($key == 'bank_account_id' && $value != null) {
                            if ($value != 0) {
                                $bank_statement_group1->where('bank_account_id', '=', $value);
                            }
                        }
                        if ($key == 'is_reconciled' && $value != null) {
                            $bank_statement_group1->where($key, $value);
                        }
                    }
                }
            })->sum('amount');
            $data['reconciled_bank_statement_total_amount'] = BankStatement::where('is_reconciled', true)->where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
                // Handle search_filter_list
                if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                    foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                        if ($key == 'from_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '>=', $value);
                        }
                        if ($key == 'to_date' && $value != null) {
                            $bank_statement_group1->where('transaction_date', '<=', $value);
                        }
                        if ($key == 'bank_account_id' && $value != null) {
                            if ($value != 0) {
                                $bank_statement_group1->where('bank_account_id', '=', $value);
                            }
                        }
                        if ($key == 'is_reconciled' && $value != null) {
                            $bank_statement_group1->where($key, $value);
                        }
                    }
                }
            })->sum('amount');

            $data['bank_statement_transaction_type_count'] = BankStatement::select(DB::raw('sum(amount) as total_amount, transaction_type'))->orderBy('transaction_type', 'asc')
                ->where(function (Builder $bank_statement_group1) use ($getBankStatementListDataUserDTO) {
                    // Handle search_filter_list
                    if (! empty($getBankStatementListDataUserDTO['search_filter_list'])) {
                        foreach ($getBankStatementListDataUserDTO['search_filter_list'] as $key => $value) {
                            if ($key == 'from_date' && $value != null) {
                                $bank_statement_group1->where('transaction_date', '>=', $value);
                            }
                            if ($key == 'to_date' && $value != null) {
                                $bank_statement_group1->where('transaction_date', '<=', $value);
                            }
                            if ($key == 'bank_account_id' && $value != null) {
                                if ($value != 0) {
                                    $bank_statement_group1->where('bank_account_id', '=', $value);
                                }
                            }
                            if ($key == 'is_reconciled' && $value != null) {
                                $bank_statement_group1->where($key, $value);
                            }
                        }
                    }
                })->where('is_reconciled', false)
                ->groupBy('transaction_type')
                ->get();

            // After Intent

            // Return Response
            return array_merge($bankStatement->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetBankStatementListDataResDTO = GetBankStatementListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetBankStatementListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
