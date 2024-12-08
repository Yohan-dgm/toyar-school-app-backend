<?php

namespace Modules\UserManagement\Intents\User\GetUserListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;

class GetUserListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getUserListDataUserDTO = GetUserListDataUserDTO::validate($payloadArray);

        // Action
        $userListData = User::where(function (Builder $user_query_group1) use ($getUserListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getUserListDataUserDTO) && $getUserListDataUserDTO['group_filter'] != "") {
                if ($getUserListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $user_query_group2) use ($getUserListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getUserListDataUserDTO) && count($getUserListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getUserListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $user_query_group3) use ($getUserListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getUserListDataUserDTO) && $getUserListDataUserDTO['search_phrase'] != "") {
                $user_query_group3->where("full_name", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                $user_query_group3->orWhere("username", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                $user_query_group3->orWhere("email", "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
            }
        })
            ->select(
                "full_name",
                "username",
                "email",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getUserListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getUserListDataUserDTO["page"]
            );
        return $userListData;
    }
}
