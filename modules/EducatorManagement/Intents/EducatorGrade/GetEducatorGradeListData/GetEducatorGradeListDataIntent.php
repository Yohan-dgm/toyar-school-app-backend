<?php

namespace Modules\EducatorManagement\Intents\EducatorGrade\GetEducatorGradeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEducatorGradeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // EducatorGrade Data Validation
            $getEducatorGradeListDataUserDTO = GetEducatorGradeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $educatorGradeListData = GetEducatorGradeListDataAction::run($getEducatorGradeListDataUserDTO, $actionData);
            $data['educatorGrade_count'] = DB::table('educator_grade')->count();
            // After Intent

            // Return Response
            return array_merge($educatorGradeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEducatorGradeListDataResDTO = GetEducatorGradeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetEducatorGradeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
