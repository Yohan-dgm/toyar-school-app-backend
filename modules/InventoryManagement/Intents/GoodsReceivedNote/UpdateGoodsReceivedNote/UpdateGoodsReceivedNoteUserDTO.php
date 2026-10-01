<?php

namespace Modules\InventoryManagement\Intents\GoodsReceivedNote\UpdateGoodsReceivedNote;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateGoodsReceivedNoteUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $id,
        public mixed $purchase_order_id,
        public mixed $date,
        public mixed $reference_number,
        public mixed $is_receival_complete,
        public mixed $office_notes,
        public mixed $goods_received_note_item_list,
        public mixed $goods_received_note_unsaved_attachment_list,
        public mixed $goods_received_note_attachment_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
        ];
    }
}
