<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentById;

use Spatie\LaravelData\Data;

class GetStudentByIdResDTO extends Data
{
    public function __construct(
        public int $id,
        public ?string $admission_number,
        public ?string $full_name,
        public ?string $full_name_with_title,
        public ?string $student_calling_name,
        public ?string $gender,
        public ?string $date_of_birth,
        public ?string $blood_group,
        public ?string $phone,
        public ?string $email,
        public ?string $student_phone,
        public ?string $student_email,
        public ?string $full_address,
        public ?string $student_address,
        public ?string $joined_date,
        public ?string $school_studied_before,
        public ?string $special_conditions,
        public ?string $special_health_conditions,
        public ?bool $has_dropped_out,
        public ?bool $is_school_leaver,
        public ?bool $is_sport_list,
        public ?array $grade_level,
        public ?array $grade_level_class,
        public ?array $school_house,
        public ?array $father,
        public ?array $mother,
        public ?array $guardian,
        public ?array $financial_info,
        public ?array $created_info,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            admission_number: $data['admission_number'] ?? null,
            full_name: $data['full_name'] ?? null,
            full_name_with_title: $data['full_name_with_title'] ?? null,
            student_calling_name: $data['student_calling_name'] ?? null,
            gender: $data['gender'] ?? null,
            date_of_birth: $data['date_of_birth'] ?? null,
            blood_group: $data['blood_group'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            student_phone: $data['student_phone'] ?? null,
            student_email: $data['student_email'] ?? null,
            full_address: $data['full_address'] ?? null,
            student_address: $data['student_address'] ?? null,
            joined_date: $data['joined_date'] ?? null,
            school_studied_before: $data['school_studied_before'] ?? null,
            special_conditions: $data['special_conditions'] ?? null,
            special_health_conditions: $data['special_health_conditions'] ?? null,
            has_dropped_out: $data['has_dropped_out'] ?? null,
            is_school_leaver: $data['is_school_leaver'] ?? null,
            is_sport_list: $data['is_sport_list'] ?? null,
            grade_level: $data['grade_level'] ?? null,
            grade_level_class: $data['grade_level_class'] ?? null,
            school_house: $data['school_house'] ?? null,
            father: $data['father'] ?? null,
            mother: $data['mother'] ?? null,
            guardian: $data['guardian'] ?? null,
            financial_info: $data['financial_info'] ?? null,
            created_info: $data['created_info'] ?? null,
        );
    }
}
