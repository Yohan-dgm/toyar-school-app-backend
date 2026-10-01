<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class MaterialItemUnitPrice extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_item_unit_price';

    protected $fillable = [
        'material_item_id',
        'unit_price',
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
}
