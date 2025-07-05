<?php

namespace Modules\GeneralEntityManagement\Intents\Unit\Unit;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUnitListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getUnitListDataUserDTO = GetUnitListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $UnitListData = GetUnitListDataAction::run($getUnitListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["unit_count"] = DB::table("unit")->count();

            // After Intent

            // Return Response
            return array_merge($UnitListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            // Get Intent Result
            $result = $this->handle($request);
            // Response Data Validation
            $getUnitListDataResDTO = GetUnitListDataResDTO::validate($result);
            // Send Response
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $getUnitListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
