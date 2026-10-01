<?php

namespace Modules\AdmissionManagement\Intents\Applicant\GetApplicantListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AdmissionManagement\Models\Applicant;
use Modules\ProgramManagement\Models\GradeLevel;

class GetApplicantListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Applicant Data Validation
            $getApplicantListDataUserDTO = GetApplicantListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $applicantListData = GetApplicantListDataAction::run($getApplicantListDataUserDTO, $actionData);
            $data['applicant_count'] = DB::table('applicant')->count();
            $data['waiting_list_applicant_count'] = Applicant::where('has_converted_to_student', false)->count();
            $data['converted_applicant_count'] = Applicant::where('has_converted_to_student', true)->count();
            $data['grade_level_applicant_count'] = GradeLevel::select('id', 'name')->withCount(['applicant_list' => function (Builder $applicant_list_query) {}])->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($applicantListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetApplicantListDataResDTO = GetApplicantListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetApplicantListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
