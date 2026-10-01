<?php

namespace Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelsWithClasses;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevel;

class GetGradeLevelsWithClassesAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // GradeLevel Data Validation
        $getGradeLevelsWithClassesUserDTO = GetGradeLevelsWithClassesUserDTO::validate($payloadArray);

        // Action
        $gradeLevelListData = GradeLevel::where(function (Builder $gradeLevel_query_group1) use ($getGradeLevelsWithClassesUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getGradeLevelsWithClassesUserDTO) && $getGradeLevelsWithClassesUserDTO['group_filter'] != '') {
                if ($getGradeLevelsWithClassesUserDTO['group_filter'] == 'All') {
                } else {
                }
            }
        })->where(function (Builder $gradeLevel_query_group2) use ($getGradeLevelsWithClassesUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getGradeLevelsWithClassesUserDTO) && ! is_null($getGradeLevelsWithClassesUserDTO['search_filter_list']) && count($getGradeLevelsWithClassesUserDTO['search_filter_list']) > 0) {
                foreach ($getGradeLevelsWithClassesUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $gradeLevel_query_group3) use ($getGradeLevelsWithClassesUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getGradeLevelsWithClassesUserDTO) && $getGradeLevelsWithClassesUserDTO['search_phrase'] != '') {
                $gradeLevel_query_group3->where('name', 'ILIKE', '%'.$getGradeLevelsWithClassesUserDTO['search_phrase'].'%');
            }
        })
            ->with(['grade_level_class_list' => function (Builder $grade_level_class_list_query) {
                $grade_level_class_list_query->select('id', 'name', 'grade_level_id')
                    ->orderBy('id', 'asc');
            }])
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'asc')
            ->paginate(
                $perPage = 100,
                $columns = ['*'],
                $pageName = 'page',
                $page = $getGradeLevelsWithClassesUserDTO['page']
            );

        return $gradeLevelListData;
    }
}
