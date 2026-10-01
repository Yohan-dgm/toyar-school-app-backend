<?php

namespace Modules\AccountManagement\Intents\IncomeNote\UpdateIncomeNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateIncomeNoteSystemDTO extends Data
{
    public function __construct(
        public mixed $is_income_note_complete,
        public mixed $income_note_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
