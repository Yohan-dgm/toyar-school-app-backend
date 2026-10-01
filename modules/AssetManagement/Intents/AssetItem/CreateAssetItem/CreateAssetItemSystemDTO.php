<?php

namespace Modules\AssetManagement\Intents\AssetItem\CreateAssetItem;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAssetItemSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
