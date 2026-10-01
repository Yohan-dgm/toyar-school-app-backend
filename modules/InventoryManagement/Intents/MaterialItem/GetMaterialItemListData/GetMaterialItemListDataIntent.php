<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\GetMaterialItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\InventoryManagement\Models\MaterialItemType;

class GetMaterialItemListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // MaterialItem Data Validation
            $getMaterialItemListDataUserDTO = GetMaterialItemListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            // $actionData['user_id'] = $request->user()->id;
            $MaterialItemListData = GetMaterialItemListDataAction::run($getMaterialItemListDataUserDTO, $actionData);
            $data['material_item_count'] = DB::table('material_item')->where('is_active', 1)->count();
            $data['material_item_type_material_item_count'] = MaterialItemType::select('id', 'name')->withCount(['material_item_list' => function (Builder $material_item_type_list_query) {
                $material_item_type_list_query->where('is_active', 1);
            }])->orderBy('sequential_order', 'asc')->get();
            // After Intent

            // Return Response
            return array_merge($MaterialItemListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetMaterialItemListDataResDTO = GetMaterialItemListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetMaterialItemListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
