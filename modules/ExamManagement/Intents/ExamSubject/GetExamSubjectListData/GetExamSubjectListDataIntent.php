<?php

namespace Modules\ExamManagement\Intents\ExamSubject\GetExamSubjectListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectCategory;

class GetExamSubjectListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // User Data Validation
            $getExamSubjectListDataUserDTO = GetExamSubjectListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $examSubjectListData = GetExamSubjectListDataAction::run($getExamSubjectListDataUserDTO, $actionData);

            // Action 2
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $data['exam_subject_count'] = DB::table('exam_subject')->count();
            $data['exam_subject_category_exam_subject_count'] = ExamSubjectCategory::select('id', 'name')->withCount(['exam_subject_list' => function (Builder $exam_subject_list_query) {}])->orderBy('id', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($examSubjectListData->toArray(), $data);
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
            $getExamSubjectListDataResDTO = GetExamSubjectListDataResDTO::validate($result);

            // Send Response
            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $getExamSubjectListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
