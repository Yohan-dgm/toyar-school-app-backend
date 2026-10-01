<?php

namespace Modules\CalendarManagement\Intents\Calendar\GetCalendarDataByMonth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCalendarDataByMonthIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getCalendarDataByMonthUserDTO = GetCalendarDataByMonthUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $calendarData = GetCalendarDataByMonthAction::run($getCalendarDataByMonthUserDTO, $actionData);

            // After Intent

            // Return Response
            return $calendarData;
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
            $getCalendarDataByMonthResDTO = GetCalendarDataByMonthResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getCalendarDataByMonthResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
