<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\GetServicesReceivedNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\PurchasingManagement\Models\ServicesReceivedNote;

class GetServicesReceivedNoteListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // ServicesReceivedNote Data Validation
        $getServicesReceivedNoteListDataUserDTO = GetServicesReceivedNoteListDataUserDTO::validate($payloadArray);

        // Action
        $services_received_note = ServicesReceivedNote::where(function (Builder $services_received_note_group1) use ($getServicesReceivedNoteListDataUserDTO) {
            // Handle group_filter
            if (! empty($getServicesReceivedNoteListDataUserDTO['group_filter']) && $getServicesReceivedNoteListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $services_received_note_group2) use ($getServicesReceivedNoteListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getServicesReceivedNoteListDataUserDTO['search_filter_list'])) {
                foreach ($getServicesReceivedNoteListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $services_received_note_group3) use ($getServicesReceivedNoteListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getServicesReceivedNoteListDataUserDTO) && $getServicesReceivedNoteListDataUserDTO['search_phrase'] != '') {

                $services_received_note_group3->orWhere('serial_number', 'ILIKE', '%'.$getServicesReceivedNoteListDataUserDTO['search_phrase'].'%');

                $services_received_note_group3->orWhereHas('supplier', function (Builder $supplier_query) use ($getServicesReceivedNoteListDataUserDTO) {
                    return $supplier_query->where('name', 'ILIKE', '%'.$getServicesReceivedNoteListDataUserDTO['search_phrase'].'%');
                });

                $services_received_note_group3->orWhereHas('services_received_note_item_list', function (Builder $services_received_note_item_list_query) use ($getServicesReceivedNoteListDataUserDTO) {
                    return $services_received_note_item_list_query->where('print_description', 'ILIKE', '%'.$getServicesReceivedNoteListDataUserDTO['search_phrase'].'%');
                });
            }
        })
            ->with(['services_received_note_item_list' => function (Builder $services_received_note_item_list_query) {
                //
                $services_received_note_item_list_query->with(['purchase_order_item' => function (Builder $purchase_order_item_query) {
                    //
                    $purchase_order_item_query->with(['material_item' => function (Builder $material_item_query) {
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
                    }])->select('*');
                }])->select('*');
            }])
            ->select(
                'id',
                'purchase_order_id',
                'date',
                'reference_number',
                'office_notes',
                //
                'serial_number',
                //
                'is_services_received_note_complete',
                'services_received_note_status_id',
            )
            ->orderBy('serial_number_digits', 'desc')
            ->paginate(
                $perPage = $getServicesReceivedNoteListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getServicesReceivedNoteListDataUserDTO['page']
            );

        return $services_received_note;
    }
}
