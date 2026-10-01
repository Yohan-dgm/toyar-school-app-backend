<?php

namespace Modules\SystemEntityManagement\Intents\Term\GetTermListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SystemEntityManagement\Models\Term;

class GetTermListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Term Data Validation
        $getTermListDataUserDTO = GetTermListDataUserDTO::validate($payloadArray);

        // Action
        $termListData = Term::where(function (Builder $term_query_group1) use ($getTermListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getTermListDataUserDTO) && $getTermListDataUserDTO['group_filter'] != '') {
                if ($getTermListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $term_query_group2) use ($getTermListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getTermListDataUserDTO) && ! is_null($getTermListDataUserDTO['search_filter_list']) && count($getTermListDataUserDTO['search_filter_list']) > 0) {
                // foreach ($getTermListDataUserDTO['search_filter_list'] as $key => $value) {
                //     if ($key == "start_term" && $value == true) {
                //         $currunt_term = Term::where('is_current_term', true)->get();
                //         $term_query_group2->where("id", ">", $currunt_term[0]->id);
                //     }
                // }
            }
        })->where(function (Builder $term_query_group3) use ($getTermListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getTermListDataUserDTO) && $getTermListDataUserDTO['search_phrase'] != '') {
                $term_query_group3->where('name', 'ILIKE', '%'.$getTermListDataUserDTO['search_phrase'].'%');
            }
        })
            ->with(['school_fee_list' => function (Builder $school_fee_list_query) {
                //
                $school_fee_list_query->select('*')->where('is_active', true);
            }])
            ->select(
                'id',
                'name',
                'school_year',
                'start_date',
                'end_date',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getTermListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getTermListDataUserDTO['page']
            );

        return $termListData;
    }
}
