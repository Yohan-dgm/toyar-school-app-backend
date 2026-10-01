<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\GetServicesReceivedNoteItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\ServicesReceivedNoteItem;

class GetServicesReceivedNoteItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ServicesReceivedNoteItem Data Validation
        $getServicesReceivedNoteItemListDataUserDTO = GetServicesReceivedNoteItemListDataUserDTO::validate($payloadArray);

        // Action
        $services_received_note_item = ServicesReceivedNoteItem::where(function (Builder $services_received_note_item_group1) use ($getServicesReceivedNoteItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getServicesReceivedNoteItemListDataUserDTO['group_filter']) && $getServicesReceivedNoteItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $services_received_note_item_group2) use ($getServicesReceivedNoteItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getServicesReceivedNoteItemListDataUserDTO['search_filter_list'])) {
                foreach ($getServicesReceivedNoteItemListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $services_received_note_item_group3) use ($getServicesReceivedNoteItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getServicesReceivedNoteItemListDataUserDTO) && $getServicesReceivedNoteItemListDataUserDTO['search_phrase'] != '') {
            }
        })->with(['material_item' => function (Builder $material_item_query) {
            //
            $material_item_query->with(['material_item_type' => function (Builder $material_item_type_query) {
                //
                $material_item_type_query->select('*');
            }])->with(['material_item_category' => function (Builder $material_item_category_query) {
                //
                $material_item_category_query->select('*');
            }])->with(['unit' => function (Builder $unit_query) {
                //
                $unit_query->select('*');
            }])->select('*');
        }])->select(
            'services_received_note_id',
            'purchase_order_id',
            'purchase_order_item_id',
            'ordered_quantity',
            'item_unit',
            'received_quantity',
            'received_by_id',
            'shelf_life_start_date',
            'shelf_life_end_date',
            'is_services_received_note_item_complete',
            'created_by',
            'updated_by'
        )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getServicesReceivedNoteItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getServicesReceivedNoteItemListDataUserDTO['page']
            );

        return $services_received_note_item;
    }
}
