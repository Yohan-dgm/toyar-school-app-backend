<?php

namespace Modules\EmployeeManagement\Intents\EmployeeType\GetEmployeeTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEmployeeTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // EmployeeType Data Validation
            $getEmployeeTypeListDataUserDTO = GetEmployeeTypeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $employeeTypeListData = GetEmployeeTypeListDataAction::run($getEmployeeTypeListDataUserDTO, $actionData);
            $data['employeeType_count'] = DB::table('employee_type')->count();
            // After Intent

            // Return Response
            return array_merge($employeeTypeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEmployeeTypeListDataResDTO = GetEmployeeTypeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetEmployeeTypeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
