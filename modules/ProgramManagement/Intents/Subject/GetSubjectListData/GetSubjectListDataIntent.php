<?php

namespace Modules\ProgramManagement\Intents\Subject\GetSubjectListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSubjectListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Subject Data Validation
            $getSubjectListDataUserDTO = GetSubjectListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['subject_id'] = $request->user()->id;
            $subjectListData = GetSubjectListDataAction::run($getSubjectListDataUserDTO, $actionData);
            $data['subject_count'] = DB::table('subject')->count();
            // After Intent

            // Return Response
            return array_merge($subjectListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetSubjectListDataResDTO = GetSubjectListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetSubjectListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
