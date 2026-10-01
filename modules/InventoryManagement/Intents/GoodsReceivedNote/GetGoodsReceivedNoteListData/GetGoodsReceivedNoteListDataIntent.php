<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\GetGoodsReceivedNoteListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGoodsReceivedNoteListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // GoodsReceivedNote Data Validation
            $getGoodsReceivedNoteListDataUserDTO = GetGoodsReceivedNoteListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $gradeLevelList = GetGoodsReceivedNoteListDataAction::run($getGoodsReceivedNoteListDataUserDTO, $actionData);
            $data['goods_received_note_count'] = DB::table('goods_received_note')->count();

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
            $GetGoodsReceivedNoteListDataResDTO = GetGoodsReceivedNoteListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetGoodsReceivedNoteListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
