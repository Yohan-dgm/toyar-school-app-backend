<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Modules\InventoryManagement\Models\GoodsReceivedNoteItem;
use Modules\InventoryManagement\Models\MaterialItem;

class MaterialBillItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_bill_item';

    protected $fillable = [
        'material_bill_id',
        'material_item_id',
        'item_quantity',
        'print_description',
        'print_quantity',
        'print_unit',
        'ordered_quantity',
        'billed_quantity',
        'issued_quantity',
        'is_material_bill_item_complete',
        'unit_price',
        'item_total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function material_bill(): BelongsTo
    {
        return $this->belongsTo(MaterialBill::class, 'material_bill_id', 'id');
    }

    public function material_item(): BelongsTo
    {
        return $this->belongsTo(MaterialItem::class, 'material_item_id', 'id');
    }

    public function goods_received_note_item(): HasOne
    {
        return $this->hasone(GoodsReceivedNoteItem::class, 'material_bill_item_id', 'id');
    }
}
