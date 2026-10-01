<?php

namespace Modules\AccountManagement\Intents\IncomeNote\GetIncomeNoteListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\IncomeNote;

class GetIncomeNoteListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // IncomeNote Data Validation
        $getIncomeNoteListDataUserDTO = GetIncomeNoteListDataUserDTO::validate($payloadArray);

        // Action
        $incomeNoteListData = IncomeNote::where(function (Builder $incomeNote_query_group1) use ($getIncomeNoteListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getIncomeNoteListDataUserDTO) && $getIncomeNoteListDataUserDTO['group_filter'] != '') {
                if ($getIncomeNoteListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $incomeNote_query_group2) use ($getIncomeNoteListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getIncomeNoteListDataUserDTO) && ! is_null($getIncomeNoteListDataUserDTO['search_filter_list']) && count($getIncomeNoteListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getIncomeNoteListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $incomeNote_query_group3) use ($getIncomeNoteListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getIncomeNoteListDataUserDTO) && $getIncomeNoteListDataUserDTO['search_phrase'] != '') {
                $incomeNote_query_group3->where('serial_number', 'ILIKE', '%'.$getIncomeNoteListDataUserDTO['search_phrase'].'%');
            }
        })->with(['income_party' => function (Builder $income_party_query) {
            //
            $income_party_query->select('*');
        }])->with(['income_type' => function (Builder $income_type_query) {
            //
            $income_type_query->select('*');
        }])->with(['income_category' => function (Builder $income_category_query) {
            //
            $income_category_query->select('*');
        }])->select(
            'id',
            'date',
            'income_party_id',
            'general_income_party_info',
            'income_type_id',
            'income_category_id',
            'amount',
            'office_notes',
            //
            'serial_number',
            'is_income_note_complete',
            'income_note_status_id',
            'created_by',
            'updated_by',
        )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = $getIncomeNoteListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getIncomeNoteListDataUserDTO['page']
            );

        return $incomeNoteListData;
    }
}
