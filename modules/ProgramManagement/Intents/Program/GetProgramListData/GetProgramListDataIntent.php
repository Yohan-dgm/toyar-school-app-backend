<?php

namespace Modules\ProgramManagement\Intents\Program\GetProgramListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetProgramListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Program Data Validation
            $getProgramListDataUserDTO = GetProgramListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['program_id'] = $request->user()->id;
            $programListData = GetProgramListDataAction::run($getProgramListDataUserDTO, $actionData);
            $data["program_count"] = DB::table("program")->count();
            // After Intent

            // Return Response
            return array_merge($programListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetProgramListDataResDTO = GetProgramListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetProgramListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
