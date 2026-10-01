<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateNotificationUserDTO extends Data
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
            'target_data.user_id' => 'required_if:target_type,user|integer|exists:user,id',
            'target_data.user_ids' => 'array',
            'target_data.user_ids.*' => 'integer|exists:user,id',
            'target_data.roles' => 'array',
            'target_data.roles.*' => 'string',
            'target_data.grade_level_class_ids' => 'array',
            'target_data.grade_level_class_ids.*' => 'integer',
            'target_data.grade_level_ids' => 'array',
            'target_data.grade_level_ids.*' => 'integer',
            'action_url' => 'nullable|string|max:500',
            'action_text' => 'nullable|string|max:100',
            'image_url' => 'nullable|string|max:500',
            'is_scheduled' => 'nullable|boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:now',
            // 'school_id' => 'nullable|integer|exists:schools,id',
        ];
    }
}
