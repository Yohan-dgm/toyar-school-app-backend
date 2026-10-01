<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\GetPurchaseRequestNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class GetPurchaseRequestNoteListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // PurchaseRequestNote Data Validation
        $getPurchaseRequestNoteListDataUserDTO = GetPurchaseRequestNoteListDataUserDTO::validate($payloadArray);

        // Action
        $purchase_request_note = PurchaseRequestNote::where(function (Builder $purchase_request_note_group1) use ($getPurchaseRequestNoteListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getPurchaseRequestNoteListDataUserDTO) && $getPurchaseRequestNoteListDataUserDTO['group_filter'] != '') {
                if ($getPurchaseRequestNoteListDataUserDTO['group_filter'] == 'All') {
                } else {
                    $purchase_request_note_group1->whereHas('purchase_request_note_status_list', function (Builder $purchase_request_note_status_list_query) use ($getPurchaseRequestNoteListDataUserDTO) {
                        $purchase_request_note_status_list_query->whereHas('purchase_request_note_status_type', function (Builder $purchase_request_note_status_type_query) use ($getPurchaseRequestNoteListDataUserDTO) {
                            return $purchase_request_note_status_type_query->where('name', '=', $getPurchaseRequestNoteListDataUserDTO['group_filter']);
                        });

                        return $purchase_request_note_status_list_query->where('is_active', true);
                    });
                }
            }
        })->where(function (Builder $purchase_request_note_group2) use ($getPurchaseRequestNoteListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getPurchaseRequestNoteListDataUserDTO) && ! is_null($getPurchaseRequestNoteListDataUserDTO['search_filter_list']) && count($getPurchaseRequestNoteListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getPurchaseRequestNoteListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $purchase_request_note_group3) use ($getPurchaseRequestNoteListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getPurchaseRequestNoteListDataUserDTO) && $getPurchaseRequestNoteListDataUserDTO['search_phrase'] != '') {

                $purchase_request_note_group3->orWhere('serial_number', 'ILIKE', '%'.$getPurchaseRequestNoteListDataUserDTO['search_phrase'].'%');
                $purchase_request_note_group3->orWhere('requirement', 'ILIKE', '%'.$getPurchaseRequestNoteListDataUserDTO['search_phrase'].'%');

                $purchase_request_note_group3->orWhereHas('material_item', function (Builder $material_item_query) use ($getPurchaseRequestNoteListDataUserDTO) {
                    return $material_item_query->where('name', 'ILIKE', '%'.$getPurchaseRequestNoteListDataUserDTO['search_phrase'].'%');
                });

                $purchase_request_note_group3->orWhere('service_item_description', 'ILIKE', '%'.$getPurchaseRequestNoteListDataUserDTO['search_phrase'].'%');

                $purchase_request_note_group3->orWhereHas('requested_by', function (Builder $requested_by_query) use ($getPurchaseRequestNoteListDataUserDTO) {
                    return $requested_by_query->where('full_name', 'ILIKE', '%'.$getPurchaseRequestNoteListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['material_item' => function (Builder $material_item_query) {
                //
                $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                    //
                    $material_item_type_query->select('id', 'name');
                }])
                    ->with(['material_item_category' => function (Builder $material_item_category_query) {
                        //
                        $material_item_category_query->select('id', 'name');
                    }])
                    ->with(['unit' => function (Builder $unit_query) {
                        //
                        $unit_query->select('id', 'name');
                    }])
                    ->select('id', 'material_item_type_id', 'unit_id', 'material_item_category_id', 'name');
            }])
            ->with(['requested_by' => function (Builder $requested_by_query) {
                //
                $requested_by_query->select('id', 'full_name');
            }])
            ->with(['purchase_request_note_status' => function (Builder $purchase_request_note_status_query) {
                //
                $purchase_request_note_status_query
                    ->with(['purchase_request_note_status_type' => function (Builder $purchase_request_note_status_type_query) {
                        //
                        $purchase_request_note_status_type_query->select('id', 'name');
                    }])
                    ->select('id', 'purchase_request_note_status_type_id', 'notes');
            }])
            ->select(
                'id',
                'item_type',
                'material_item_id',
                'service_item_description',
                'date',
                'quantity',
                'requested_by_id',
                'requirement',
                'purchase_request_note_status_id',
                'serial_number',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getPurchaseRequestNoteListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getPurchaseRequestNoteListDataUserDTO['page']
            );

        // After Intent

        return $purchase_request_note;
    }
}
