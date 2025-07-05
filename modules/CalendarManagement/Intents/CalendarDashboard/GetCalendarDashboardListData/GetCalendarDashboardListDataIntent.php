<?php

namespace Modules\CalendarManagement\Intents\CalendarDashboard\GetCalendarDashboardListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetCalendarDashboardListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // CalendarDashboard Data Validation
            $getCalendarDashboardListDataUserDTO = GetCalendarDashboardListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetCalendarDashboardListDataAction::run($getCalendarDashboardListDataUserDTO, $actionData);
            $data["event_category_count"] = DB::table("event_category")->count();


            // After Intent

            // Return Response
            return array_merge($gradeLevelList->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetCalendarDashboardListDataResDTO = GetCalendarDashboardListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetCalendarDashboardListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
