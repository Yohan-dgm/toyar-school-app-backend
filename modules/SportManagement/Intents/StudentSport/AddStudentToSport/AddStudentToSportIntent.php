<?php

namespace Modules\SportManagement\Intents\StudentSport\AddStudentToSport;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddStudentToSportIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // User Data Validation
            $addStudentToSportUserDTO = AddStudentToSportUserDTO::validate($request->all());

            // System data
            $systemData = [
                'created_by' => $request->user()->id,
            ];

            // Execute action
            $studentSport = AddStudentToSportAction::run($addStudentToSportUserDTO, $systemData);

            DB::commit();

            return $studentSport;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);

            return response()->json([
                'status' => 'successful',
                'message' => 'Student successfully added to sport',
                'data' => $result,
                'metadata' => null,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => null,
                'metadata' => null,
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }
}
