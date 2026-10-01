<?php

namespace Modules\AccountManagement\Intents\IncomeParty\GetIncomePartyListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetIncomePartyListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // IncomeParty Data Validation
            $getIncomePartyListDataUserDTO = GetIncomePartyListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $income_partyListData = GetIncomePartyListDataAction::run($getIncomePartyListDataUserDTO, $actionData);
            $data['income_party_count'] = DB::table('income_party')->count();

            // After Intent

            // Return Response
            return array_merge($income_partyListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetIncomePartyListDataResDTO = GetIncomePartyListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetIncomePartyListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
