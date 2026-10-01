<?php

namespace Modules\EmployeeManagement\Intents\Employee\GetEmployeeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEmployeeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Employee Data Validation
            $getEmployeeListDataUserDTO = GetEmployeeListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $employeeListData = GetEmployeeListDataAction::run($getEmployeeListDataUserDTO, $actionData);
            $data['employee_count'] = DB::table('employee')->count();
            // After Intent

            // Return Response
            return array_merge($employeeListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEmployeeListDataResDTO = GetEmployeeListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetEmployeeListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
