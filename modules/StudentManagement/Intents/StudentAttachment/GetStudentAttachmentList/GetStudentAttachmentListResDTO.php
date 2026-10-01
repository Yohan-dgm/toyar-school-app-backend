<?php

namespace Modules\StudentManagement\Intents\StudentAttachment\GetStudentAttachmentList;

use Spatie\LaravelData\Data;

class GetStudentAttachmentListResDTO extends Data
{
    public function __construct(
        public array $attachments,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attachments: $data['attachments'] ?? [],
        );
    }
}
