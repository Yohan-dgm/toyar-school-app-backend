<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateNotificationDTO extends Data
{
    public function __construct(
        public int $notification_type_id,
        public string $title,
        public string $message,
        public string $priority,
        public string $target_type,
        public ?array $target_data,
        public ?string $action_url,
        public ?string $action_text,
        public ?string $image_url,
        public ?bool $is_scheduled,
        public ?string $scheduled_at,
        public ?string $expires_at,
        // public ?int $school_id,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'notification_type_id' => 'required|integer|exists:notification_types,id',
            'title' => 'required|string|max:500',
            'message' => 'required|string',
            'priority' => 'required|in:normal,high,urgent',
            'target_type' => 'required|in:broadcast,user,role,class,grade',
            'target_data' => 'nullable|array',
            'action_url' => 'nullable|string|max:500',
            'action_text' => 'nullable|string|max:100',
            'image_url' => 'nullable|string|max:500',
            'is_scheduled' => 'nullable|boolean',
            'scheduled_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            // 'school_id' => 'nullable|integer',
            'created_by' => 'required|integer|exists:user,id',
        ];
    }
}
