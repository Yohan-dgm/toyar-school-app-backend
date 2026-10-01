<?php

namespace Modules\AccountManagement\Intents\IncomeNote\GetIncomeNoteListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetIncomeNoteListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // IncomeNote Data Validation
            $getIncomeNoteListDataUserDTO = GetIncomeNoteListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $incomeNoteListData = GetIncomeNoteListDataAction::run($getIncomeNoteListDataUserDTO, $actionData);
            $data['income_note_count'] = DB::table('income_note')->count();
            // After Intent

            // Return Response
            return array_merge($incomeNoteListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetIncomeNoteListDataResDTO = GetIncomeNoteListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetIncomeNoteListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
