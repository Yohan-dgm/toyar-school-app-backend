<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetStudentListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Student Data Validation
        $getStudentListDataUserDTO = GetStudentListDataUserDTO::validate($payloadArray);

        // Action
        $studentListData = Student::where(function (Builder $student_query_group1) use ($getStudentListDataUserDTO) {
            // group_filter
            if (array_key_exists('group_filter', $getStudentListDataUserDTO) && $getStudentListDataUserDTO['group_filter'] != "") {
                if ($getStudentListDataUserDTO['group_filter'] == "All") {
                } else {
                }
            }
        })->where(function (Builder $student_query_group2) use ($getStudentListDataUserDTO) {
            // search_filter_list
            if (array_key_exists('search_filter_list', $getStudentListDataUserDTO) && count($getStudentListDataUserDTO['search_filter_list']) > 0) {
                foreach ($getStudentListDataUserDTO['search_filter_list'] as $key => $value) {
                }
            }
        })->where(function (Builder $student_query_group3) use ($getStudentListDataUserDTO) {
            // search_phrase
            if (array_key_exists('search_phrase', $getStudentListDataUserDTO) && $getStudentListDataUserDTO['search_phrase'] != "") {
                $student_query_group3->where("full_name", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("admission_number", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("joined_date", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("gender", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("full_name_with_title", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("admission_fee_discount_percentage", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("approved_admission_fee", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("applicable_refundable_deposit", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                $student_query_group3->orWhere("applicable_year_payment", "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");

                $student_query_group3->orWhereHas('grade_level', function (Builder $grade_level_query) use ($getStudentListDataUserDTO) {
                    return $grade_level_query->where('name', "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                });
                $student_query_group3->orWhereHas('student_admission_source', function (Builder $student_admission_source_query) use ($getStudentListDataUserDTO) {
                    return $student_admission_source_query->where('name', "ILIKE", "%" . $getStudentListDataUserDTO['search_phrase'] . "%");
                });
            }
        })
            ->with(['grade_level' => function (Builder $grade_level_query) {
                //
                $grade_level_query->select("id", "name");
            }])
            ->with(['student_admission_source' => function (Builder $student_admission_source_query) {
                //
                $student_admission_source_query->select("id", "name");
            }])
            ->select(
                "id",
                "full_name",
                "admission_number",
                "joined_date",
                "gender",
                "full_name_with_title",
                "grade_level_id",
                "student_admission_source_id",
                "admission_fee_discount_percentage",
                "approved_admission_fee",
                "applicable_refundable_deposit",
                "applicable_term_payment",
                "applicable_year_payment",
            )
            ->orderBy("id", "desc")
            ->paginate(
                $perPage = $getStudentListDataUserDTO["page_size"],
                $columns = ['*'],
                $pageName = 'page',
                $page = $getStudentListDataUserDTO["page"]
            );
        return $studentListData;
    }
}
