<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\GetPurchaseRequestNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseRequestNoteStatusType;

class GetPurchaseRequestNoteListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // PurchaseRequestNote Data Validation
            $getPurchaseRequestNoteListDataUserDTO = GetPurchaseRequestNoteListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetPurchaseRequestNoteListDataAction::run($getPurchaseRequestNoteListDataUserDTO, $actionData);
            $data['purchase_request_note_count'] = DB::table('purchase_request_note')->count();
            $data['purchase_request_note_status_type_purchase_request_note_status_count'] = PurchaseRequestNoteStatusType::select('id', 'name')->withCount(['purchase_request_note_status_list' => function (Builder $purchase_request_note_status_list_query) {
                $purchase_request_note_status_list_query->where('is_active', true);
            }])->orderBy('sequential_order', 'asc')->get();

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
            $GetPurchaseRequestNoteListDataResDTO = GetPurchaseRequestNoteListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetPurchaseRequestNoteListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
