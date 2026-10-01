<?php

namespace Modules\UserManagement\Intents\UserPayment\GetCurrentUserPayments;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentUserPaymentsUserDTO extends Data
{
    public function __construct(
        // Optional filters
        public ?bool $active_only = null,
        public ?string $package_type = null,
        public ?bool $include_students = true,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'active_only' => ['nullable', 'boolean'],
            'package_type' => ['nullable', 'string', 'in:basic,family,premium,annual'],
            'include_students' => ['nullable', 'boolean'],
        ];
    }

    public static function messages(): array
    {
        return [
            'active_only.boolean' => 'Active only filter must be true or false',
            'package_type.in' => 'Package type must be one of: basic, family, premium, annual',
            'include_students.boolean' => 'Include students must be true or false',
        ];
    }
}