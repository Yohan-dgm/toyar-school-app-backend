<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetNotificationUserTypeListDataResDTO extends Data
{
    public function __construct(
        public ?array $data,
        public int $total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // 'data'  => ['required', 'array'],
            'total' => ['required', 'integer'],
        ];
    }
}
