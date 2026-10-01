<?php

namespace Modules\MaterialManagement\Intents\MaterialIssueNote\CompleteMaterialIssueNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompleteMaterialIssueNoteDTO extends Data
{
    public function __construct(
        // user
        public ?int $material_issue_note_id,
        public ?int $inventory_item_id,

        // system
        public ?int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'material_issue_note_id' => [new Required],
            'inventory_item_id' => [new Required],

            // system
            'created_by' => [new Required],
        ];
    }
}
