<?php

namespace Modules\EducatorManagement\Intents\Educator\GetEducatorClassStudents;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetEducatorClassStudentsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Get authenticated user from action data
        $authenticatedUser = $actionData['authenticatedUser'];

        // Validate user category is educator (2)
        if ($authenticatedUser->user_category != 2 && $authenticatedUser->user_category !== '2') {
            throw new \Exception('Access denied. Only educators can access this endpoint.');
        }

        // Student Data Validation
        $getEducatorClassStudentsUserDTO = GetEducatorClassStudentsUserDTO::validate($payloadArray);

        // Build the complex query to get students from educator's assigned grade levels
        $studentListData = Student::whereHas('grade_level', function (Builder $gradeLevelQuery) use ($authenticatedUser) {
            $gradeLevelQuery->whereHas('educator_list', function (Builder $educatorQuery) use ($authenticatedUser) {
                $educatorQuery->whereHas('employee', function (Builder $employeeQuery) use ($authenticatedUser) {
                    $employeeQuery->where('user_id', $authenticatedUser->id);
                });
            });
        })
        ->where(function (Builder $student_query_group) use ($getEducatorClassStudentsUserDTO) {
            // search_phrase filter
            if (array_key_exists('search_phrase', $getEducatorClassStudentsUserDTO) && $getEducatorClassStudentsUserDTO['search_phrase'] != '') {
                $student_query_group->where(function (Builder $search_query) use ($getEducatorClassStudentsUserDTO) {
                    $search_query->where('full_name', 'ILIKE', '%' . $getEducatorClassStudentsUserDTO['search_phrase'] . '%')
                                 ->orWhere('admission_number', 'ILIKE', '%' . $getEducatorClassStudentsUserDTO['search_phrase'] . '%');
                });
            }
        })
        ->with([
            // Grade level information  
            'grade_level' => function ($gradeLevelQuery) {
                $gradeLevelQuery->select('id', 'name');
            },
            // Grade level class information
            'grade_level_class' => function ($gradeLevelClassQuery) {
                $gradeLevelClassQuery->select('id', 'name', 'grade_level_id');
            },
            // Student attachments
            'student_attachment_list' => function ($attachmentQuery) {
                $attachmentQuery->select('id', 'student_id', 'file_name', 'original_file_name', 'mime_type', 'created_at');
            },
            // Nationality information
            'nationality' => function ($nationalityQuery) {
                $nationalityQuery->select('id', 'name');
            },
            // Religion information  
            'religion' => function ($religionQuery) {
                $religionQuery->select('id', 'name');
            },
            // School house information
            'school_house' => function ($schoolHouseQuery) {
                $schoolHouseQuery->select('id', 'name');
            }
        ])
        ->select(
            'id',
            'admission_number',
            'full_name',
            'full_name_with_title',
            'gender',
            'date_of_birth',
            'grade_level_id',
            'grade_level_class_id',
            'nationality_id',
            'religion_id',
            'school_house_id',
            'phone',
            'email',
            'student_phone',
            'student_email',
            'full_address',
            'special_conditions',
            // Parent information
            'father_full_name',
            'father_phone',
            'father_email',
            'father_occupation',
            'mother_full_name', 
            'mother_phone',
            'mother_email',
            'mother_occupation',
            'guardian_full_name',
            'guardian_phone',
            'guardian_email',
            'guardian_occupation',
            'joined_date',
            'created_at',
            'updated_at'
        )
        ->orderBy('full_name', 'asc')
        ->paginate(
            $perPage = $getEducatorClassStudentsUserDTO['page_size'],
            $columns = ['*'],
            $pageName = 'page',
            $page = $getEducatorClassStudentsUserDTO['page']
        );

        return $studentListData;
    }
}