<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $student_count,
        public ?object $dropped_out_student_count,
        public ?object $incomplete_student_count,
        public ?object $incomplete_address_student_count,
        public ?object $incomplete_photo_student_count,
        public ?object $grade_level_student_count,
        public ?object $school_house_student_count,
        public ?object $school_leaver_student_count,
        public ?object $grade_level_teacher_role_list,

        public ?object $school_Senior_prefect_role_list,
        public ?object $school_junior_prefect_role_list,
        public ?object $school_game_captain,
        public ?object $school_deputy_game_captain,
        public ?object $school_head_prefect,
        public ?object $school_deputy_head_prefect,

        public ?object $calypso_house_captain_role_list,
        public ?object $eurus_house_captain_role_list,
        public ?object $tellus_house_captain_role_list,
        public ?object $vulcan_house_captain_role_list,
        public ?object $house_deputy_captain_role_list,

        public ?object $deputy_calypso_house_captain_role_list,
        public ?object $deputy_eurus_house_captain_role_list,
        public ?object $deputy_tellus_house_captain_role_list,
        public ?object $deputy_vulcan_house_captain_role_list,

        public ?object $grade_level_class_moniter,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
