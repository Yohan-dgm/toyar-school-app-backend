<?php

namespace Modules\UserManagement\Intents\User\GetPublicStudentList;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetPublicStudentListDTO extends Data
{
    public function __construct(
        public int $user_id,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'user_id' => [new Required(), new IntegerType(), new Exists('user', 'id')],
        ];
    }
}
