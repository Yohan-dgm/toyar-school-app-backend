<?php

namespace Modules\StudentManagement\Intents\SchoolHouse\GetSchoolHouseListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSchoolHouseListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // SchoolHouse Data Validation
            $getSchoolHouseListDataUserDTO = GetSchoolHouseListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $schoolHouseListData = GetSchoolHouseListDataAction::run($getSchoolHouseListDataUserDTO, $actionData);
            $data['school_house_count'] = DB::table('school_house')->count();
            // After Intent

            // Return Response
            return array_merge($schoolHouseListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetSchoolHouseListDataResDTO = GetSchoolHouseListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSchoolHouseListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
