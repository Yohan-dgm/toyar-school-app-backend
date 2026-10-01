<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\GetGoodsReceivedNoteItemListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGoodsReceivedNoteItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GoodsReceivedNoteItem Data Validation
            $getGoodsReceivedNoteItemListDataUserDTO = GetGoodsReceivedNoteItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetGoodsReceivedNoteItemListDataAction::run($getGoodsReceivedNoteItemListDataUserDTO, $actionData);
            $data['goods_received_note_item_count'] = DB::table('goods_received_note_item')->count();

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
            $GetGoodsReceivedNoteItemListDataResDTO = GetGoodsReceivedNoteItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGoodsReceivedNoteItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
