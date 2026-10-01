<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoiceItem\GetSportFeeInvoiceItemListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\SportFeeInvoiceItem;

class GetSportFeeInvoiceItemListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SportFeeInvoiceItem Data Validation
        $getSportFeeInvoiceItemListDataUserDTO = GetSportFeeInvoiceItemListDataUserDTO::validate($payloadArray);

        // Action
        $sport_fee_invoice_item = SportFeeInvoiceItem::where(function (Builder $sport_fee_invoice_item_group1) use ($getSportFeeInvoiceItemListDataUserDTO) {
            // Handle group_filter
            if (! empty($getSportFeeInvoiceItemListDataUserDTO['group_filter']) && $getSportFeeInvoiceItemListDataUserDTO['group_filter'] === 'All') {
            }
        })->where(function (Builder $sport_fee_invoice_item_group2) use ($getSportFeeInvoiceItemListDataUserDTO) {
            // Handle search_filter_list
            if (! empty($getSportFeeInvoiceItemListDataUserDTO['search_filter_list'])) {
                foreach ($getSportFeeInvoiceItemListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($key == 'sport_fee_invoice_id' && $value != null) {
                        $sport_fee_invoice_item_group2->where('sport_fee_invoice_id', $value);
                    }
                }
            }
        })->where(function (Builder $sport_fee_invoice_item_group3) use ($getSportFeeInvoiceItemListDataUserDTO) {
            // Handle search_phrase
            if (array_key_exists('search_phrase', $getSportFeeInvoiceItemListDataUserDTO) && $getSportFeeInvoiceItemListDataUserDTO['search_phrase'] != '') {
            }
        })->select(
            'id',
            'sport_fee_invoice_id',
            'school_fee_id',
            'description',
            'is_sport_fee_invoice_item_complete',
            'unit_price',
            'qty',
            'item_total',
        )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getSportFeeInvoiceItemListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSportFeeInvoiceItemListDataUserDTO['page']
            );

        return $sport_fee_invoice_item;
    }
}
