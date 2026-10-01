<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\GetMisconductLevelListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMisconductLevelListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $getMisconductLevelListDataUserDTO = GetMisconductLevelListDataUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];

            $misconductLevelList = GetMisconductLevelListDataAction::run($getMisconductLevelListDataUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $misconductLevelList;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $result,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
