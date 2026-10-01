<?php

namespace Modules\CanteenManagement\Intents\MealPlan\UpdateMealPlan;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\MimeTypes;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateMealPlanUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $title,
        public ?string $description,
        public float $price,
        public int $quantity_available,
        public ?bool $is_active,
        public ?UploadedFile $image,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'title' => [new Required, new StringType],
            'description' => [],
            'price' => [new Required, new Numeric, new Min(0)],
            'quantity_available' => [new Required, new IntegerType, new Min(0)],
            'is_active' => [],
            'image' => [
                new File,
                new Image,
                new Max(5120),
                new MimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),
            ],
            // system
        ];
    }
}
