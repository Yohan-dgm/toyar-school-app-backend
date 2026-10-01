<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\UpdateGoodsReceivedNote;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGoodsReceivedNoteIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Authorization

            // 2. User Data Validation
            $updateGoodsReceivedNoteUserDTO = UpdateGoodsReceivedNoteUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $actionData['goods_received_note_item_list'] = $request->goods_received_note_item_list;
            $actionData['goods_received_note_unsaved_attachment_list'] = $request->goods_received_note_unsaved_attachment_list;
            $actionData['goods_received_note_attachment_list'] = $request->goods_received_note_attachment_list;
            $goodsReceivedNote = UpdateGoodsReceivedNoteAction::run($updateGoodsReceivedNoteUserDTO, $actionData);

            DB::commit();
            // After Intent

            // Return Response
            return $goodsReceivedNote;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => '',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'failed',
                        'message' => '',
                        'data' => null,
                        'metadata' => null,
                    ],
                    500
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
