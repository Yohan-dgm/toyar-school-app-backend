<?php

namespace Modules\SportManagement\Intents\StudentSport\GetStudentSportRecords;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetStudentSportRecordsIntent
{
    use AsAction;

    public function handle(Request $request, int $student_id): GetStudentSportRecordsResDTO
    {
        // Prepare request data with route parameters
        $requestData = array_merge($request->all(), [
            'student_id' => $student_id,
        ]);

        // User Data Validation
        $getStudentSportRecordsUserDTO = GetStudentSportRecordsUserDTO::validate($requestData);

        // Execute action
        return GetStudentSportRecordsAction::run($getStudentSportRecordsUserDTO);
    }

    public function asController(Request $request, int $student_id): JsonResponse
    {
        try {
            $result = $this->handle($request, $student_id);

            return response()->json([
                'status' => 'successful',
                'message' => 'Student sport records retrieved successfully',
                'data' => $result->toArray(),
                'metadata' => [
                    'student_id' => $student_id,
                    'filters_applied' => array_filter([
                        'sport_id' => $request->get('sport_id'),
                        'action_type' => $request->get('action_type'),
                        'from_date' => $request->get('from_date'),
                        'to_date' => $request->get('to_date'),
                        'include_active_only' => $request->get('include_active_only'),
                    ]),
                ],
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
