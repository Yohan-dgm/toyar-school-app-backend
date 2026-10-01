<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\GetServicesReceivedNoteListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetServicesReceivedNoteListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ServicesReceivedNote Data Validation
            $getServicesReceivedNoteListDataUserDTO = GetServicesReceivedNoteListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetServicesReceivedNoteListDataAction::run($getServicesReceivedNoteListDataUserDTO, $actionData);
            $data['services_received_note_count'] = DB::table('services_received_note')->count();

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
            $GetServicesReceivedNoteListDataResDTO = GetServicesReceivedNoteListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetServicesReceivedNoteListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
