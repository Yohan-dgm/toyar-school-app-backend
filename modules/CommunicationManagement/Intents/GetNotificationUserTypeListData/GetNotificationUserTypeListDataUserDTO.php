<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetNotificationUserTypeListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $group_filter,   // example: "All"
        public ?string $search_phrase,
        public ?int $grade_level_id,
        public ?int $grade_level_class_id,
        public ?int $student_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // 'group_filter' => [new Required()],
        ];
    }
}
