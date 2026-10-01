<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\UpdateGoodsReceivedNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateGoodsReceivedNoteDTO extends Data
{
    public function __construct(
        // user
        public mixed $purchase_order_id,
        public mixed $date,
        public mixed $reference_number,
        public mixed $is_receival_complete,
        public mixed $office_notes,
        // system
        public mixed $is_goods_received_note_complete,
        public mixed $goods_received_note_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'updated_by' => [new Required],
        ];
    }
}
