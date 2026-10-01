<?php

namespace Modules\ProgramManagement\Intents\Sport\GetSportListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\Sport;

class GetSportListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Sport Data Validation
        $getSportListDataUserDTO = GetSportListDataUserDTO::validate($payloadArray);

        // Action
        $sportListData = Sport::where(function (Builder $sport_query_group1) use ($getSportListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSportListDataUserDTO) && $getSportListDataUserDTO['group_filter'] != '') {
                if ($getSportListDataUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $sport_query_group2) use ($getSportListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSportListDataUserDTO) && ! is_null($getSportListDataUserDTO['search_filter_list']) && count($getSportListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSportListDataUserDTO['search_filter_list'] as $key => $value) {
                    if ($value != null) {
                        $sport_query_group2->where($key, $value);
                    }
                }
            }
        })->where(function (Builder $sport_query_group3) use ($getSportListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSportListDataUserDTO) && $getSportListDataUserDTO['search_phrase'] != '') {
                $sport_query_group3->where('name', 'ILIKE', '%'.$getSportListDataUserDTO['search_phrase'].'%');
                $sport_query_group3->orWhere('sport_code', 'ILIKE', '%'.$getSportListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
                'sport_code',
            )
            ->orderBy('name', 'asc')
            ->paginate(
                $perPage = $getSportListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSportListDataUserDTO['page']
            );

        return $sportListData;
    }
}
