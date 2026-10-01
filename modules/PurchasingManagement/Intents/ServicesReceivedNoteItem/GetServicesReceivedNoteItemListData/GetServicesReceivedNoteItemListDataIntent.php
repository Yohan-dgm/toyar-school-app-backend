<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\GetServicesReceivedNoteItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetServicesReceivedNoteItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // ServicesReceivedNoteItem Data Validation
            $getServicesReceivedNoteItemListDataUserDTO = GetServicesReceivedNoteItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetServicesReceivedNoteItemListDataAction::run($getServicesReceivedNoteItemListDataUserDTO, $actionData);
            $data['services_received_note_item_count'] = DB::table('services_received_note_item')->count();

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
            $GetServicesReceivedNoteItemListDataResDTO = GetServicesReceivedNoteItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetServicesReceivedNoteItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
