<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetStudentAchievements;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\StudentAchievement;

class GetStudentAchievementsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getStudentAchievementsUserDTO = GetStudentAchievementsUserDTO::validate($payloadArray);

        $studentAchievementsListData = StudentAchievement::where(function (Builder $studentAchievement_query_group1) use ($getStudentAchievementsUserDTO) {
            if (array_key_exists('group_filter', $getStudentAchievementsUserDTO) && $getStudentAchievementsUserDTO['group_filter'] != '') {
                if ($getStudentAchievementsUserDTO['group_filter'] == 'active') {
                    $studentAchievement_query_group1->where('is_active', '=', true);
                } elseif ($getStudentAchievementsUserDTO['group_filter'] == 'inactive') {
                    $studentAchievement_query_group1->where('is_active', '=', false);
                }
            }
        })->where(function (Builder $studentAchievement_query_group2) use ($getStudentAchievementsUserDTO) {
            if (array_key_exists('search_filter_list', $getStudentAchievementsUserDTO) && ! is_null($getStudentAchievementsUserDTO['search_filter_list']) && count($getStudentAchievementsUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentAchievementsUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $studentAchievement_query_group3) use ($getStudentAchievementsUserDTO) {
            if (array_key_exists('search_phrase', $getStudentAchievementsUserDTO) && $getStudentAchievementsUserDTO['search_phrase'] != '') {
                $studentAchievement_query_group3->where('title', 'ILIKE', '%'.$getStudentAchievementsUserDTO['search_phrase'].'%')
                    ->orWhere('achievement_type', 'ILIKE', '%'.$getStudentAchievementsUserDTO['search_phrase'].'%')
                    ->orWhere('description', 'ILIKE', '%'.$getStudentAchievementsUserDTO['search_phrase'].'%');
            }
        })->where(function (Builder $studentAchievement_query_group4) use ($getStudentAchievementsUserDTO) {
            if (array_key_exists('student_id', $getStudentAchievementsUserDTO) && $getStudentAchievementsUserDTO['student_id']) {
                $studentAchievement_query_group4->where('student_id', '=', $getStudentAchievementsUserDTO['student_id']);
            }
        })
            ->with(['student'])
            ->select(
                'id',
                'student_id',
                'achievement_type',
                'title',
                'description',
                'is_active',
                'start_date',
                'end_date',
                'created_at',
                'updated_at'
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getStudentAchievementsUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentAchievementsUserDTO['page']
            );

        return $studentAchievementsListData;
    }
}
