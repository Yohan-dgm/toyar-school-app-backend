<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Spatie\LaravelData\Data;
use Modules\UserManagement\Models\UserProfileImage;

class UploadUserProfilePhotoResDTO extends Data
{
    public function __construct(
        public int $id,
        public int $user_id,
        public string $file_path,
        public string $filename,
        public string $file_format,
        public int $file_size,
        public string $file_size_formatted,
        public string $mime_type,
        public ?int $width,
        public ?int $height,
        public ?string $dimensions_string,
        public bool $is_active,
        public string $full_url,
        public string $public_path,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromModel(UserProfileImage $profileImage): self
    {
        return new self(
            id: $profileImage->id,
            user_id: $profileImage->user_id,
            file_path: $profileImage->file_path,
            filename: $profileImage->filename,
            file_format: $profileImage->file_format,
            file_size: $profileImage->file_size,
            file_size_formatted: $profileImage->getFormattedSize(),
            mime_type: $profileImage->mime_type,
            width: $profileImage->width,
            height: $profileImage->height,
            dimensions_string: $profileImage->getDimensionsString(),
            is_active: $profileImage->is_active,
            full_url: $profileImage->getFullUrl(),
            public_path: $profileImage->getPublicPath(),
            created_at: $profileImage->created_at->format('Y-m-d H:i:s'),
            updated_at: $profileImage->updated_at->format('Y-m-d H:i:s'),
        );
    }
}