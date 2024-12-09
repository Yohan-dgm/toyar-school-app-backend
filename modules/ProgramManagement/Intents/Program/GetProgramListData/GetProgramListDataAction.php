<?php

namespace Modules\ProgramManagement\Intents\Program\GetProgramListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\Program;

class GetProgramListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Program Data Validation
        $getProgramListDataUserDTO = GetProgramListDataUserDTO::validate($payloadArray);

        // Action
        $programListData = Program::where(function (Builder $program_query_group1) use ($getProgramListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getProgramListDataUserDTO) && $getProgramListDataUserDTO['group_filter'] != "") {
                if ($getProgramListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $program_query_group2) use ($getProgramListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getProgramListDataUserDTO) && count($getProgramListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getProgramListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $program_query_group3) use ($getProgramListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getProgramListDataUserDTO) && $getProgramListDataUserDTO['search_phrase'] != "") {
                $program_query_group3->where("name", "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");
                $program_query_group3->orWhere("program_code", "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");

                $program_query_group3->orWhereHas('grade_level', function (Builder $grade_level_query) use ($getProgramListDataUserDTO) {
                    return $grade_level_query->where('name', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");
                });
                $program_query_group3->orWhereHas('curriculum_type', function (Builder $curriculum_type_query) use ($getProgramListDataUserDTO) {
                    return $curriculum_type_query->where('name', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");
                });
                $program_query_group3->orWhereHas('subject_list', function (Builder $subject_list_query) use ($getProgramListDataUserDTO) {
                    return $subject_list_query->where('name', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%")
                        ->orWhere('subject_code', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%")
                        ->orWhereHas('stream', function (Builder $stream_query) use ($getProgramListDataUserDTO) {
                            return $stream_query->where('name', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");
                        });
                });
                $program_query_group3->orWhereHas('school_location_list', function (Builder $school_location_list_query) use ($getProgramListDataUserDTO) {
                    return $school_location_list_query->where('name', "ILIKE", "%" . $getProgramListDataUserDTO['search_phrase'] . "%");
                });
            }
        })
            ->with(['grade_level' => function (Builder $grade_level_query) {
                //
                $grade_level_query->select("id", "name");
            }])
            ->with(['curriculum_type' => function (Builder $curriculum_type_query) {
                //
                $curriculum_type_query->select("id", "name");
            }])
            ->with(['subject_list' => function (Builder $subject_list_query) {
                //
                $subject_list_query->with(['stream' => function (Builder $stream_query) {
                    //
                    $stream_query->select("stream.id", "stream.name");
                }])->select("id", "program_id", "stream_id", "name", "subject_code");
            }])
            ->with(['school_location_list' => function (Builder $school_location_list_query) {
                $school_location_list_query->select("school_location_id", "name");
            }])
            ->select(
                "id",
                "name",
                "program_code",
                "grade_level_id",
                "curriculum_type_id",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getProgramListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getProgramListDataUserDTO["page"]
            );
        return $programListData;
    }
}
