<?php

namespace Modules\AccountManagement\Intents\StudentPendingInvoice\GetStudentPendingInvoiceListData;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Symfony\Contracts\Service\Attribute\Required;

class GetStudentPendingInvoiceListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $student_name,
        public array|string|null $admission_number,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'admission_number' => ['nullable'],

            // system
        ];
    }
}
