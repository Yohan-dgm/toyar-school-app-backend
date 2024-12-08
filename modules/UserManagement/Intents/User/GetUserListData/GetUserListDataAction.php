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
                    $user_query_group1->whereHas('user_status_type', function (Builder $user_status_type_query) use ($getUserListDataUserDTO) {
                        return $user_status_type_query->where('name', '=', $getUserListDataUserDTO['group_filter']);
                    });
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
                $user_query_group3->where('amount', "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                $user_query_group3->orWhere('serial_number', "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                $user_query_group3->orWhereHas('student', function (Builder $student_query) use ($getUserListDataUserDTO) {
                    return $student_query->where('full_name', "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                });
                $user_query_group3->orWhereHas('applicant', function (Builder $applicant_query) use ($getUserListDataUserDTO) {
                    return $applicant_query->where('full_name', "ILIKE", "%" . $getUserListDataUserDTO['search_phrase'] . "%");
                });
            }
        })
            ->with(['student' => function (Builder $student_query) {
                //
                $student_query->select("id", "full_name");
            }])
            ->with(['applicant' => function (Builder $applicant_query) {
                //
                $applicant_query->with(['carer_profile_list' => function (Builder $carer_profile_list_query) {
                    //
                    $carer_profile_list_query->select("carer_profile.id", "carer_profile.carer_type", "carer_profile.full_name", "carer_profile.phone");
                }])->select("id", "gender", "full_name");
            }])
            ->with(['user_status_type' => function (Builder $user_status_type_query) {
                //
                $user_status_type_query->select("id", "name");
            }])
            ->select(
                "id",
                "serial_number",
                "receipt_party",
                "student_id",
                "applicant_id",
                "narration",
                "amount",
                "payment_method",
                "bank_account_id",
                "bank_deposit_date",
                "cash_account_id",
                "cash_received_date",
                "check_type",
                "check_bank_id",
                "check_number",
                "check_received_date",
                "check_date",
                "payment_received_by_id",
                "payment_received_date",
                "user_status_type_id",
            )
            ->orderBy("payment_received_date", "desc")
            ->paginate(
                $perPage = $getUserListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getUserListDataUserDTO["page"]
            );
        return $userListData;
    }
}
