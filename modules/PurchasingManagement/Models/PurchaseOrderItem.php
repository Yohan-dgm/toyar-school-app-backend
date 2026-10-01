<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\InventoryManagement\Models\MaterialItem;

class PurchaseOrderItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_order_item';

    protected $fillable = [
        'purchase_order_id',
        'item_type',
        'material_item_id',
        'item_quantity',
        'print_description',
        'print_quantity',
        'print_unit',
        'ordered_quantity',
        'billed_quantity',
        'received_quantity',
        'is_purchase_order_item_complete',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function material_item(): BelongsTo
    {
        return $this->belongsTo(MaterialItem::class, 'material_item_id', 'id');
    }

    public function goods_received_note_item(): HasOne
    {
        return $this->hasone(GoodsReceivedNoteItem::class, 'purchase_order_item_id', 'id');
    }
}
