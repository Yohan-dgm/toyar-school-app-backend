<?php

namespace Modules\GeneralEntityManagement\Intents\PersonTitle\GetPersonTitleListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPersonTitleListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getPersonTitleListDataUserDTO = GetPersonTitleListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $PersonTitleListData = GetPersonTitleListDataAction::run($getPersonTitleListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data["person_title_count"] = DB::table("person_title")->count();

            // After Intent

            // Return Response
            return array_merge($PersonTitleListData->toArray(), $data);
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
            $getPersonTitleListDataResDTO = GetPersonTitleListDataResDTO::validate($result);
            // Send Response
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $getPersonTitleListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
