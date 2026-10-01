<?php

namespace Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAnnouncementSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => 'required|integer|exists:user,id',
        ];
    }
}
