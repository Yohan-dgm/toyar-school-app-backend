<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\EmployeeManagement\Models\Employee;
use Modules\PurchasingManagement\Models\PurchaseOrderItem;

class GoodsReceivedNoteItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'goods_received_note_item';

    protected $fillable = [
        'goods_received_note_id',
        'purchase_order_id',
        'purchase_order_item_id',
        'ordered_quantity',
        'item_unit',
        'received_quantity',
        'received_by_id',
        'shelf_life_start_date',
        'shelf_life_end_date',
        'is_goods_received_note_item_complete',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function goods_received_note(): BelongsTo
    {
        return $this->belongsTo(GoodsReceivedNote::class, 'goods_received_note_id', 'id');
    }

    public function purchase_order_item(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id', 'id');
    }

    public function received_by(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'received_by_id', 'id');
    }
}
