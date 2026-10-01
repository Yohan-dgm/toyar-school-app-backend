<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetStudentDisciplineSummary;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentDisciplineSummaryIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $getStudentDisciplineSummaryUserDTO = GetStudentDisciplineSummaryUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];

            $summary = GetStudentDisciplineSummaryAction::run($getStudentDisciplineSummaryUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $summary;
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
