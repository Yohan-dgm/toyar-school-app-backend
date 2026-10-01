<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\MaterialBillItem;
use Modules\GeneralEntityManagement\Models\Unit;
use Modules\PurchasingManagement\Models\PurchaseOrderItem;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class MaterialItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_item';

    protected $fillable = [
        'name',
        'material_item_type_id',
        'material_item_category_id',
        'material_item_sub_category_id',
        'unit_id',
        'reorder_level',
        'is_expirable',
        'unit_price',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function material_item_type(): BelongsTo
    {
        return $this->belongsTo(MaterialItemType::class, 'material_item_type_id', 'id');
    }

    public function material_item_category(): BelongsTo
    {
        return $this->belongsTo(MaterialItemCategory::class, 'material_item_category_id', 'id');
    }

    public function material_item_sub_category(): BelongsTo
    {
        return $this->belongsTo(MaterialItemSubCategory::class, 'material_item_sub_category_id', 'id');
    }

    public function inventory_item_list(): HasMany
    {
        return $this->hasMany(InventoryItem::class, 'material_item_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function purchase_order_item_list(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'material_item_id', 'id');
    }

    public function purchase_request_note_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNote::class, 'material_item_id', 'id');
    }

    public function material_bill_item_list(): HasMany
    {
        return $this->hasMany(MaterialBillItem::class, 'material_item_id', 'id');
    }

    public function material_item_unit_price_list(): HasMany
    {
        return $this->hasMany(MaterialItemUnitPrice::class, 'material_item_id', 'id');
    }
}
