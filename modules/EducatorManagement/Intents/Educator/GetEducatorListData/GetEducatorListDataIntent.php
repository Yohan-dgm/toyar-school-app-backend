<?php

namespace Modules\EducatorManagement\Intents\Educator\GetEducatorListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetEducatorListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Educator Data Validation
            $getEducatorListDataUserDTO = GetEducatorListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['educator_id'] = $request->user()->id;
            $educatorListData = GetEducatorListDataAction::run($getEducatorListDataUserDTO, $actionData);
            $data["educator_count"] = DB::table("educator")->count();
            // After Intent

            // Return Response
            return array_merge($educatorListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetEducatorListDataResDTO = GetEducatorListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetEducatorListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
