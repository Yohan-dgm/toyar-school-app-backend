<?php

namespace Modules\CalendarManagement\Intents\Event\GetEventListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;
use Modules\AccountManagement\Models\IncomeType;

class GetEventListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Event Data Validation
            $getEventListDataUserDTO = GetEventListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetEventListDataAction::run($getEventListDataUserDTO, $actionData);
            $data["event_count"] = DB::table("event")->count();
            $data["income_type_category_list_count"] = IncomeType::select("id", "name")->withCount(['income_category_list' => function (Builder $income_category_list_query) {}])->orderBy("sequential_order", "asc")->get();

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
            $GetEventListDataResDTO = GetEventListDataResDTO::validate($result);
            return response()->json(
                [
                    "status" => "successful",
                    "message" => "",
                    "data" => $GetEventListDataResDTO,
                    "metadata" => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
