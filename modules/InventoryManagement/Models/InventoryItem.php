<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class InventoryItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'inventory_item';

    protected $fillable = [
        'goods_received_note_id',
        'material_item_id',
        'received_date',
        'received_quantity',
        'issued_quantity',
        'current_quantity',
        'unit_price',
        'landed_rate',
        'landed_value',
        'is_expirable',
        'shelf_life_start_date',
        'shelf_life_end_date',
        'is_active',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function material_item(): BelongsTo
    {
        return $this->belongsTo(MaterialItem::class, 'material_item_id', 'id');
    }

    public function goods_received_note(): BelongsTo
    {
        return $this->belongsTo(GoodsReceivedNote::class, 'goods_received_note_id', 'id');
    }
}
