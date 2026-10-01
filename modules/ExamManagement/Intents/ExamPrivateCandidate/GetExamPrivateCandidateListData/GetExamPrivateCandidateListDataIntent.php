<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\GetExamPrivateCandidateListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExamPrivateCandidateListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamPrivateCandidateListDataUserDTO = GetExamPrivateCandidateListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examPrivateCandidateListData = GetExamPrivateCandidateListDataAction::run($getExamPrivateCandidateListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_private_candidate_count'] = DB::table('exam_private_candidate')->count();

            // After Intent

            // Return Response
            return array_merge($examPrivateCandidateListData->toArray(), $data);
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
            $getExamPrivateCandidateListDataResDTO = GetExamPrivateCandidateListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamPrivateCandidateListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
