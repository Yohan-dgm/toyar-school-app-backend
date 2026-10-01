<?php

namespace Modules\SportManagement\Intents\StudentSport\AddStudentToSport;

use Spatie\LaravelData\Data;

class AddStudentToSportSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public ?int $updated_by = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function rules(): array
    {
        return [
            'created_by' => ['required', 'integer'],
            'updated_by' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'string'],
            'updated_at' => ['nullable', 'string'],
        ];
    }
}
