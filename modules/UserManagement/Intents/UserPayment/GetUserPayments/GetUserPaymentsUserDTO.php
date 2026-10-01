<?php

namespace Modules\UserManagement\Intents\UserPayment\GetUserPayments;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetUserPaymentsUserDTO extends Data
{
    public function __construct(
        // Optional filters
        public ?int $user_id = null,
        public ?string $package_type = null,
        public ?bool $is_active = null,
        public ?string $status = null,
        
        // Optional pagination
        public int $page = 1,
        public int $page_size = 10,
        
        // Optional date filters
        public ?string $date_from = null,
        public ?string $date_to = null,
        public ?string $search_phrase = null,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // Optional filters
            'user_id' => ['nullable', new IntegerType()],
            'package_type' => ['nullable', 'string', 'in:basic,family,premium,annual'],
            'is_active' => ['nullable', 'boolean'],
            'status' => ['nullable', 'string', 'in:active,inactive,pending,expired'],
            
            // Optional pagination
            'page' => [new IntegerType()],
            'page_size' => [new IntegerType()],
            
            // Optional date filters
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'search_phrase' => ['nullable', 'string'],
        ];
    }

    public static function messages(): array
    {
        return [
            'user_id.integer' => 'User ID must be an integer',
            'package_type.in' => 'Package type must be one of: basic, family, premium, annual',
            'is_active.boolean' => 'Active status must be true or false',
            'status.in' => 'Status must be one of: active, inactive, pending, expired',
            'page.integer' => 'Page must be an integer',
            'page_size.integer' => 'Page size must be an integer',
            'date_from.date' => 'Date from must be a valid date',
            'date_to.date' => 'Date to must be a valid date',
            'search_phrase.string' => 'Search phrase must be a string',
        ];
    }
}