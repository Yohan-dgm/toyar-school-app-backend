<?php

namespace Modules\ExamManagement\Intents\ExamSubjectCategory\GetExamSubjectCategoryListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\ExamSubjectCategory;

class GetExamSubjectCategoryListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getExamSubjectCategoryListDataUserDTO = GetExamSubjectCategoryListDataUserDTO::validate($payloadArray);

        // Action
        $getExamSubjectCategoryListData = ExamSubjectCategory::where(function (Builder $exam_subject_category_query_category1) use ($getExamSubjectCategoryListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getExamSubjectCategoryListDataUserDTO) && $getExamSubjectCategoryListDataUserDTO['group_filter'] != '') {
                if ($getExamSubjectCategoryListDataUserDTO['group_filter'] == 'All') {
                }
            }
        })->where(function (Builder $exam_subject_category_query_category2) use ($getExamSubjectCategoryListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getExamSubjectCategoryListDataUserDTO) && ! is_null($getExamSubjectCategoryListDataUserDTO['search_filter_list']) && count($getExamSubjectCategoryListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getExamSubjectCategoryListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $exam_subject_category_query_category3) use ($getExamSubjectCategoryListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getExamSubjectCategoryListDataUserDTO) && $getExamSubjectCategoryListDataUserDTO['search_phrase'] != '') {
                $exam_subject_category_query_category3->where('name', 'ILIKE', '%'.$getExamSubjectCategoryListDataUserDTO['search_phrase'].'%');
            }
        })
            ->select(
                'id',
                'name',
            )
            ->orderBy('id', 'desc')
            ->paginate(
                $perPage = $getExamSubjectCategoryListDataUserDTO['page_size'],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getExamSubjectCategoryListDataUserDTO['page']
            );

        return $getExamSubjectCategoryListData;
    }
}
