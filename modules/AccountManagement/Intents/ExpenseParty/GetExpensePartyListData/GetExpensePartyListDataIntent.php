<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\GetExpensePartyListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExpensePartyListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ExpenseParty Data Validation
            $getExpensePartyListDataUserDTO = GetExpensePartyListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $expense_partyListData = GetExpensePartyListDataAction::run($getExpensePartyListDataUserDTO, $actionData);
            $data['expense_party_count'] = DB::table('expense_party')->count();

            // After Intent

            // Return Response
            return array_merge($expense_partyListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetExpensePartyListDataResDTO = GetExpensePartyListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetExpensePartyListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
