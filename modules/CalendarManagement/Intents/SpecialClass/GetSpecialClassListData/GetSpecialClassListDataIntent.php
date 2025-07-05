<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\GetSpecialClassListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetSpecialClassListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // SpecialClass Data Validation
            $getSpecialClassListDataUserDTO = GetSpecialClassListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $specialClassListData = GetSpecialClassListDataAction::run($getSpecialClassListDataUserDTO, $actionData);
            $data["special_class_count"] = DB::table("special_class")->count();
            // After Intent

            // Return Response
            return array_merge($specialClassListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetSpecialClassListDataResDTO = GetSpecialClassListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetSpecialClassListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
