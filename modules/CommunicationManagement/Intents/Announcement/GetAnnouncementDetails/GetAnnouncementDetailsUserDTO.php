<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetAnnouncementDetailsUserDTO extends Data
{
    public function __construct(
        public int $announcement_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'announcement_id' => 'required|integer|exists:announcements,id',
        ];
    }
}
