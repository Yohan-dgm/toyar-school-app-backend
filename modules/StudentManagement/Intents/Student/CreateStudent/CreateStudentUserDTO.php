<?php

namespace Modules\StudentManagement\Intents\Student\CreateStudent;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $full_name,
        public mixed $gender,
        public mixed $date_of_birth,
        public mixed $grade_level_id,
        // public mixed $school_house_id,
        public mixed $student_admission_source_id,
        public mixed $student_admission_source_other,
        public mixed $approved_admission_fee,
        public mixed $applicable_refundable_deposit,
        public mixed $applicable_term_payment,
        public mixed $student_unsaved_attachment_list,
        //
        public mixed $father_full_name,
        public mixed $father_id_type,
        public mixed $father_nic_number,
        public mixed $father_passport_number,
        public mixed $father_phone,
        public mixed $father_whatsapp,
        public mixed $father_email,
        public mixed $father_occupation,
        public mixed $father_place_of_work,
        public mixed $father_monthly_income,
        //
        public mixed $mother_full_name,
        public mixed $mother_id_type,
        public mixed $mother_nic_number,
        public mixed $mother_passport_number,
        public mixed $mother_phone,
        public mixed $mother_whatsapp,
        public mixed $mother_email,
        public mixed $mother_occupation,
        public mixed $mother_place_of_work,
        public mixed $mother_monthly_income,
        //
        public mixed $guardian_full_name,
        public mixed $guardian_id_type,
        public mixed $guardian_nic_number,
        public mixed $guardian_passport_number,
        public mixed $guardian_phone,
        public mixed $guardian_whatsapp,
        public mixed $guardian_email,
        public mixed $guardian_occupation,
        public mixed $guardian_place_of_work,
        public mixed $guardian_monthly_income,
        //
        public mixed $student_phone,
        public mixed $student_email,
        public mixed $student_address,
        public mixed $school_studied_before,
        public mixed $blood_group,
        public mixed $special_health_conditions,
        public mixed $student_calling_name,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'full_name' => [new Required, new StringType],
            'gender' => [new Required, new StringType],
            'date_of_birth' => [new Required, new Date],
            'grade_level_id' => [new Required, new IntegerType],
            'student_admission_source_id' => [new Required, new IntegerType],
        ];
    }
}
