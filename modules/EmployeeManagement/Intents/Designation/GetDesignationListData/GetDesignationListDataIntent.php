<?php

namespace Modules\EmployeeManagement\Intents\Designation\GetDesignationListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetDesignationListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Designation Data Validation
            $getDesignationListDataUserDTO = GetDesignationListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $designationListData = GetDesignationListDataAction::run($getDesignationListDataUserDTO, $actionData);
            $data['designation_count'] = DB::table('designation')->count();
            // After Intent

            // Return Response
            return array_merge($designationListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetDesignationListDataResDTO = GetDesignationListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetDesignationListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
