<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\GeneralEntityManagement\Models\Unit;
use Modules\PurchasingManagement\Models\PurchaseRequestNote;

class FixedAssetItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'fixed_asset_item';

    protected $fillable = [
        'name',
        'fixed_asset_item_type_id',
        'fixed_asset_item_category_id',
        'fixed_asset_item_sub_category_id',
        'unit_id',
        'reorder_level',
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
    public function fixed_asset_item_type(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItemType::class, 'fixed_asset_item_type_id', 'id');
    }

    public function fixed_asset_item_category(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItemCategory::class, 'fixed_asset_item_category_id', 'id');
    }

    public function fixed_asset_item_sub_category(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItemSubCategory::class, 'fixed_asset_item_sub_category_id', 'id');
    }

    public function asset_item_list(): HasMany
    {
        return $this->hasMany(AssetItem::class, 'fixed_asset_item_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function purchase_request_note_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNote::class, 'fixed_asset_item_id', 'id');
    }
}
