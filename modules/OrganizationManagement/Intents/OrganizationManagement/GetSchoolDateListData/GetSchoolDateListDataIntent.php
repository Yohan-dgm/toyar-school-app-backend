<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\GetSchoolDateListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSchoolDateListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getSchoolDateListDataUserDTO = GetSchoolDateListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $getSchoolDateListDataAction = GetSchoolDateListDataAction::run($getSchoolDateListDataUserDTO, $actionData);
            $data['school_date_count'] = DB::table('school_date')->count();
            // After Intent

            // Return Response
            return array_merge($getSchoolDateListDataAction->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $getSchoolDateListDataResDTO = GetSchoolDateListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getSchoolDateListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
