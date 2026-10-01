<?php

namespace Modules\SportManagement\Intents\StudentSport\RemoveStudentFromSport;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveStudentFromSportIntent
{
    use AsAction;

    public function handle(Request $request, int $student_id, int $sport_id)
    {
        DB::beginTransaction();
        try {
            // Prepare request data with route parameters
            $requestData = array_merge($request->all(), [
                'student_id' => $student_id,
                'sport_id' => $sport_id,
            ]);

            // User Data Validation
            $removeStudentFromSportUserDTO = RemoveStudentFromSportUserDTO::validate($requestData);

            // System data
            $systemData = [
                'updated_by' => $request->user()->id,
            ];

            // Execute action
            $studentSport = RemoveStudentFromSportAction::run($removeStudentFromSportUserDTO, $systemData);

            DB::commit();

            return $studentSport;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request, int $student_id, int $sport_id): JsonResponse
    {
        try {
            $result = $this->handle($request, $student_id, $sport_id);

            return response()->json([
                'status' => 'successful',
                'message' => 'Student successfully removed from sport',
                'data' => $result,
                'metadata' => null,
            ], 200);
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
