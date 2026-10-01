<?php

namespace Modules\ProgramManagement\Intents\Sport\GetSportListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSportListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Sport Data Validation
            $getSportListDataUserDTO = GetSportListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['sport_id'] = $request->user()->id;
            $sportListData = GetSportListDataAction::run($getSportListDataUserDTO, $actionData);
            $data['sport_count'] = DB::table('sport')->count();
            // After Intent

            // Return Response
            return array_merge($sportListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetSportListDataResDTO = GetSportListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSportListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
