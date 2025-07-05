<?php

namespace Modules\GeneralEntityManagement\Intents\Nationality\GetNationalityListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNationalityListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getNationalityListDataUserDTO = GetNationalityListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $NationalityListData = GetNationalityListDataAction::run($getNationalityListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["nationality_count"] = DB::table("nationality")->count();

            // After Intent

            // Return Response
            return array_merge($NationalityListData->toArray(), $data);
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
            $getNationalityListDataResDTO = GetNationalityListDataResDTO::validate($result);
            // Send Response
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $getNationalityListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
