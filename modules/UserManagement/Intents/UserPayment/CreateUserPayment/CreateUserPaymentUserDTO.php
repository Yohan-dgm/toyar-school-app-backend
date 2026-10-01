<?php

namespace Modules\UserManagement\Intents\UserPayment\CreateUserPayment;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUserPaymentUserDTO extends Data
{
    public function __construct(
        // Required fields
        public int $user_id,
        public string $package_type,
        public string $start_date,
        public array $student_ids,
        
        // Optional fields
        public ?string $end_date = null,
        public ?float $amount = null,
        public ?string $currency = 'LKR',
        public ?string $payment_method = null,
        public ?string $transaction_reference = null,
        public ?string $notes = null,
        public bool $is_active = true,
        public string $access_level = 'full',
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // Required fields
            'user_id' => [new Required(), new IntegerType()],
            'package_type' => [new Required(), 'string', 'in:basic,family,premium,annual'],
            'start_date' => [new Required(), 'date'],
            'student_ids' => [new Required(), 'array', 'min:1'],
            'student_ids.*' => [new IntegerType()],
            
            // Optional fields
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'transaction_reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'access_level' => ['string', 'in:full,limited,readonly'],
        ];
    }

    public static function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required',
            'user_id.integer' => 'User ID must be an integer',
            'package_type.required' => 'Package type is required',
            'package_type.in' => 'Package type must be one of: basic, family, premium, annual',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date must be a valid date',
            'student_ids.required' => 'At least one student ID is required',
            'student_ids.array' => 'Student IDs must be an array',
            'student_ids.min' => 'At least one student must be selected',
            'student_ids.*.integer' => 'Each student ID must be an integer',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after' => 'End date must be after start date',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be greater than or equal to 0',
            'currency.max' => 'Currency code must not exceed 10 characters',
            'payment_method.max' => 'Payment method must not exceed 50 characters',
            'transaction_reference.max' => 'Transaction reference must not exceed 255 characters',
            'is_active.boolean' => 'Active status must be true or false',
            'access_level.in' => 'Access level must be one of: full, limited, readonly',
        ];
    }
}