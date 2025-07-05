<?php

namespace Modules\CalendarManagement\Intents\Event\GetEventListData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetEventListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public int $page_size,
        public int $page,
        public ?int $logInUserId,
        public ?string $logInUserType,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'page_size' => [new Required(), new IntegerType()],
            'page' => [new Required(), new IntegerType()],
            // system
        ];
    }
}
