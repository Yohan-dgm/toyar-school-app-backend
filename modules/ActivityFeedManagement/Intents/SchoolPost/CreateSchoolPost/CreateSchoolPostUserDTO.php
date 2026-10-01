<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchoolPostUserDTO extends Data
{
    public function __construct(
        public ?string $type,
        public ?string $category,
        public string $title,
        public string $content,
        public ?int $school_id,
        public ?int $class_id,
        public ?int $student_id,
        public ?int $author_id,
        public ?int $media_count,
        public ?array $media,
        public ?array $hashtags,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        $rules = [
            'type' => 'nullable',
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:500',
            'content' => 'required|string',
            'school_id' => 'nullable|integer',
            'class_id' => 'nullable|integer',
            'student_id' => 'nullable|integer',
            'author_id' => 'nullable|integer',

            // New FormData Structure (Profile Upload Pattern)
            'media_count' => 'nullable|integer|min:0|max:10',

            // Legacy media support (backward compatibility)
            'media' => 'nullable|array',
            'media.*.type' => 'required_with:media|in:image,video,pdf',
            'media.*.url' => 'required_with:media|string|max:500',
            'media.*.thumbnail_url' => 'nullable|string|max:500',
            'media.*.filename' => 'required_with:media|string|max:255',
            'media.*.size' => 'required_with:media|integer|min:0',
            'media.*.mime_type' => 'nullable|string|max:100',

            // Legacy FormData file uploads
            'media_files' => 'nullable|array',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,pdf|max:51200',

            // Legacy FormData metadata
            'metadata' => 'nullable|string',

            // Support both indexed hashtags and legacy format
            'hashtags' => 'nullable',
            'hashtags.*' => 'nullable|string|max:100',
        ];

        // Add dynamic validation for indexed media files (media_0, media_1, etc.)
        $request = request();
        $mediaCount = $request->input('media_count', 0);

        if ($mediaCount > 0) {
            for ($i = 0; $i < min($mediaCount, 10); $i++) {
                $rules["media_{$i}"] = 'nullable|array';
                $rules["media_{$i}.uri"] = 'nullable|string';
                $rules["media_{$i}.type"] = 'nullable|string';
                $rules["media_{$i}.name"] = 'nullable|string|max:255';
                $rules["media_{$i}_type"] = 'nullable|in:image,video,document';
                $rules["media_{$i}_size"] = 'nullable|integer|min:0';
            }
        }

        // Add dynamic validation for indexed hashtags (hashtags[0], hashtags[1], etc.)
        if ($request->has('hashtags') && is_array($request->input('hashtags'))) {
            foreach ($request->input('hashtags') as $index => $hashtag) {
                $rules["hashtags.{$index}"] = 'nullable|string|max:100';
            }
        }

        return $rules;
    }
}
