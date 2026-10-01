<?php

namespace Modules\AccountManagement\Intents\GeneralBill\CreateGeneralBill;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateGeneralBillSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
        public string $admission_number,
        public int $admission_number_digits,
        public string $admission_number_prefix,
        public string $admission_number_current_year,
        public string $full_name_with_title,
        public Date $joined_date,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'created_by' => [new Required, new IntegerType],
            'admission_number' => [new Required, new StringType, new Unique('general_bill', 'admission_number')],
            'admission_number_digits' => [new Required, new IntegerType],
            'admission_number_prefix' => [new Required, new StringType],
            'admission_number_current_year' => [new Required, new StringType],
            'full_name_with_title' => [new Required, new StringType],
            'joined_date' => [new Required, new Date],
        ];
    }
}
