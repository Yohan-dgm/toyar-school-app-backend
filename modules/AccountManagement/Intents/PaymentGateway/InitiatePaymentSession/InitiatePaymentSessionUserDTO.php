<?php

namespace Modules\AccountManagement\Intents\PaymentGateway\InitiatePaymentSession;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class InitiatePaymentSessionUserDTO extends Data
{
    public function __construct(
        // user
        public string $invoice_type,
        public int $invoice_id,
        public float $amount,
        public int $student_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'invoice_type' => ['required', 'string', 'in:Term Fee,Admission Fee,Exam Bill,Sport Fee,Material Bill'],
            'invoice_id'   => ['required', 'integer', 'min:1'],
            'amount'       => ['required', 'numeric', 'min:1'],
            'student_id'   => ['required', 'integer', 'min:1'],
        ];
    }
}
