<?php

namespace Modules\ActivityFeedManagement\Intents\Media\UploadMedia;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UploadMediaUserDTO extends Data
{
    public function __construct(
        public ?string $post_type,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        $rules = [
            'post_type' => 'nullable|in:school-posts,class-posts,student-posts',
        ];

        // Add dynamic validation for indexed files (file_0, file_1, etc.)
        $request = request();

        // Check for files and add validation rules dynamically
        $fileCount = 0;
        for ($i = 0; $i < 10; $i++) { // Max 10 files
            if ($request->hasFile("file_{$i}")) {
                $fileCount++;
                $rules["file_{$i}"] = [
                    'required',
                    'file',
                    'mimes:jpg,jpeg,png,webp,mp4,mov,avi,pdf',
                    'max:51200', // 50MB max
                ];
            }
        }

        // Ensure at least one file is uploaded
        if ($fileCount === 0) {
            $rules['files_required'] = 'required|accepted';
        }

        return $rules;
    }

    public static function messages(): array
    {
        return [
            'post_type.in' => 'Post type must be one of: school-posts, class-posts, student-posts.',
            'file_*.required' => 'File is required.',
            'file_*.file' => 'Please upload a valid file.',
            'file_*.mimes' => 'File must be a JPG, PNG, WEBP, MP4, MOV, AVI, or PDF file.',
            'file_*.max' => 'File size cannot exceed 50MB.',
            'files_required.required' => 'At least one file must be uploaded.',
            'files_required.accepted' => 'At least one file must be uploaded.',
        ];
    }
}
