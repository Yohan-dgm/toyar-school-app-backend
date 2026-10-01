<?php

namespace Modules\SportManagement\Intents\StudentSport\AddStudentToSport;

use Spatie\LaravelData\Data;

class AddStudentToSportDTO extends Data
{
    public function __construct(
        public int $student_id,
        public int $sport_id,
        public ?int $coach_id,
        public string $enrolled_date,
        public ?string $notes,
        public bool $is_active,
        public bool $status,
        public int $created_by,
        public ?int $updated_by,
        public ?string $created_at,
        public ?string $updated_at,
    ) {}

    public static function from(AddStudentToSportUserDTO $userDTO, AddStudentToSportSystemDTO $systemDTO): self
    {
        return new self(
            student_id: $userDTO->student_id,
            sport_id: $userDTO->sport_id,
            coach_id: $userDTO->coach_id,
            enrolled_date: $userDTO->enrolled_date ?? now()->format('Y-m-d'),
            notes: $userDTO->notes,
            is_active: true,
            status: true,
            created_by: $systemDTO->created_by,
            updated_by: $systemDTO->updated_by,
            created_at: $systemDTO->created_at,
            updated_at: $systemDTO->updated_at,
        );
    }
}
