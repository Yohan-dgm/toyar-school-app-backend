<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Data;

class UploadUserProfilePhotoDTO extends Data
{
    public function __construct(
        public int $user_id,
        public string $file_path,
        public string $filename,
        public string $file_format,
        public int $file_size,
        public string $mime_type,
        public ?int $width,
        public ?int $height,
        public bool $is_active,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [new Required(), new IntegerType()],
            'file_path' => [new Required(), new StringType()],
            'filename' => [new Required(), new StringType()],
            'file_format' => [new Required(), new StringType()],
            'file_size' => [new Required(), new IntegerType()],
            'mime_type' => [new Required(), new StringType()],
            'width' => [new IntegerType()],
            'height' => [new IntegerType()],
            'is_active' => [new Required(), new BooleanType()],
            'created_by' => [new Required(), new IntegerType()],
        ];
    }
}