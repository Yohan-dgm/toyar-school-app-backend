<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\MimeTypes;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;

class UploadUserProfilePhotoUserDTO extends Data
{
    public function __construct(
        public UploadedFile $profile_image,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'profile_image' => [
                new Required(),
                new File(),
                new Image(),
                new Max(5120), // Max 5MB (5120 KB)
                new MimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),
                'dimensions:min_width=100,min_height=100,max_width=2048,max_height=2048'
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            'profile_image.required' => 'Profile image is required.',
            'profile_image.file' => 'Please upload a valid file.',
            'profile_image.image' => 'The file must be a valid image.',
            'profile_image.max' => 'The image size cannot exceed 5MB.',
            'profile_image.mimes' => 'The image must be a JPEG, JPG, PNG, or WebP file.',
            'profile_image.dimensions' => 'The image dimensions must be between 100x100 and 2048x2048 pixels.',
        ];
    }
}