<?php

namespace Modules\StudentManagement\Intents\StudentSport\GetStudentSportListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\StudentSport;

class GetStudentSportListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentSport Data Validation
            $getStudentSportListDataUserDTO = GetStudentSportListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $user_id = $request->user()->id;
            $studentSportListData = GetStudentSportListDataAction::run($getStudentSportListDataUserDTO, $actionData);
            $data['student_sport_count'] = DB::table('student_sport')->count();

            // After Intent

            // Return Response
            return array_merge($studentSportListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentSportListDataResDTO = GetStudentSportListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentSportListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
