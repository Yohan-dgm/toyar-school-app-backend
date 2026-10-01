<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExaminationStatusType;

class GetSchedulingExaminationListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getSchedulingExaminationListDataUserDTO = GetSchedulingExaminationListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $schedulingExaminationListData = GetSchedulingExaminationListDataAction::run($getSchedulingExaminationListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['scheduling_examinations_count'] = DB::table('scheduling_examination')->count();
            $data['scheduling_examinations_status_type_count'] = SchedulingExaminationStatusType::select('id', 'name')->withCount(['scheduling_examination_list' => function (Builder $scheduling_examination_list_query) {}])->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($schedulingExaminationListData->toArray(), $data);
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
            $getSchedulingExaminationListDataResDTO = GetSchedulingExaminationListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getSchedulingExaminationListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
