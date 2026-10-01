<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetAnnouncementDetailsSystemDTO extends Data
{
    public function __construct(
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => 'required|integer|exists:user,id',
        ];
    }
}
