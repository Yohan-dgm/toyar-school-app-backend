<?php

namespace Modules\CalendarManagement\Intents\SpecialClass\GetSpecialClassListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CalendarManagement\Models\SpecialClass;

class GetSpecialClassListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // SpecialClass Data Validation
        $getSpecialClassListDataUserDTO = GetSpecialClassListDataUserDTO::validate($payloadArray);

        // Action
        $specialClassListData = SpecialClass::where(function (Builder $specialClass_query_group1) use ($getSpecialClassListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getSpecialClassListDataUserDTO) && $getSpecialClassListDataUserDTO['group_filter'] != "") {
                if ($getSpecialClassListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $specialClass_query_group2) use ($getSpecialClassListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getSpecialClassListDataUserDTO) && !is_null($getSpecialClassListDataUserDTO['search_filter_list']) && count($getSpecialClassListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getSpecialClassListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $specialClass_query_group3) use ($getSpecialClassListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getSpecialClassListDataUserDTO) && $getSpecialClassListDataUserDTO['search_phrase'] != "") {
                $specialClass_query_group3->where("title", "ILIKE", "%" . $getSpecialClassListDataUserDTO['search_phrase'] . "%");
            }
            $specialClass_query_group3->orWhereHas('program', function (Builder $program_query) use ($getSpecialClassListDataUserDTO) {
                return $program_query->where('name', "ILIKE", "%" . $getSpecialClassListDataUserDTO['search_phrase'] . "%");
            });
            $specialClass_query_group3->orWhereHas('subject', function (Builder $subject_query) use ($getSpecialClassListDataUserDTO) {
                return $subject_query->where('name', "ILIKE", "%" . $getSpecialClassListDataUserDTO['search_phrase'] . "%");
            });
        })
            ->with(['program' => function (Builder $program_query) {
                //
                $program_query->select("id", "name");
            }])
            ->with(['subject' => function (Builder $subject_query) {
                //
                $subject_query->select("id", "name", "subject_code");
            }])

            ->select(
                "id",
                'title',
                'program_id',
                'subject_id',
                'special_class_date',
                'start_time',
                'end_time',
                'description',
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getSpecialClassListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getSpecialClassListDataUserDTO["page"]
            );
        return $specialClassListData;
    }
}
