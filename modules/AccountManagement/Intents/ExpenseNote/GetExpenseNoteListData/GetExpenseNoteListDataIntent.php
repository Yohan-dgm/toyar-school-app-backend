<?php

namespace Modules\AccountManagement\Intents\ExpenseNote\GetExpenseNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\ExpenseNote;
use Modules\AccountManagement\Models\ExpenseType;
use Modules\AccountManagement\Models\PaymentVoucher;

class GetExpenseNoteListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ExpenseNote Data Validation
            $getExpenseNoteListDataUserDTO = GetExpenseNoteListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $expenseNoteListData = GetExpenseNoteListDataAction::run($getExpenseNoteListDataUserDTO, $actionData);
            $data['expense_note_count'] = DB::table('expense_note')->where('is_active', true)->count();
            $data['expense_type_count'] = ExpenseType::select('id', 'name')->withCount(['expense_note_list' => function (Builder $expense_note_list) {
                // return $expense_note_list->where("has_dropped_out", false);
                return $expense_note_list->where('is_active', true);
            }])->orderBy('id', 'asc')->get();
            $data['payment_completed_expense_count'] = ExpenseNote::select('id')
                ->where('is_expense_note_complete', true)
                ->where('is_active', true)
                ->count();
            $data['due_payment_expense_count'] = ExpenseNote::select('id')
                ->where('is_expense_note_complete', false)
                ->where('is_active', true)
                ->count();
            $data['payment_due_expense_total_amount'] =
                ExpenseNote::where('is_expense_note_complete', false)->where('is_active', true)->sum('amount')
                -
                PaymentVoucher::whereHas('expense_note', function ($expense_note_query) {
                    $expense_note_query->where(function (Builder $expense_note_group1) {
                        $expense_note_group1->where('is_expense_note_complete', false)
                            ->where('is_active', true);
                    });
                })->where('is_active', true)->sum('amount');

            // After Intent

            // Return Response
            return array_merge($expenseNoteListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetExpenseNoteListDataResDTO = GetExpenseNoteListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetExpenseNoteListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
