<?php

namespace Modules\UserManagement\Intents\User\GetUserListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class GetUserListDataAction
{
    use AsAction;

    public function handle($payloadArray)
    {
        // User Data Validation
        $getUserListDataUserDTO = GetUserListDataUserDTO::validate($payloadArray);
        // System Data Preperation

        // System Data Validation

        // Action
        $userListData = User::where(function (Builder $user_query,) use ($getUserListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getUserListDataUserDTO) && $getUserListDataUserDTO['group_filter'] != "") {
            }
            // search_filter_list
            if (array_key_exists('search_filter_list', $getUserListDataUserDTO) && count($getUserListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getUserListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
            // search_phrase
            if (array_key_exists('search_phrase', $getUserListDataUserDTO) && $getUserListDataUserDTO['search_phrase'] != "") {
                $user_query->where("full_name", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%")
                    ->orWhere("username", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%")
                    ->orWhere("email", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->orderBy("id", "asc")
            ->paginate(
                $perPage = $getUserListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getUserListDataUserDTO["page"]
            );

        return $userListData;
    }
}
