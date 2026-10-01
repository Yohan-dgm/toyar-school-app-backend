<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class FixedAssetItemCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'fixed_asset_item_category';

    protected $fillable = [
        'fixed_asset_item_type_id',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function fixed_asset_item_type(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItemType::class, 'fixed_asset_item_type_id', 'id');
    }

    public function fixed_asset_item_sub_category_list(): HasMany
    {
        return $this->hasMany(FixedAssetItemSubCategory::class, 'fixed_asset_item_category_id', 'id');
    }

    public function fixed_asset_item_list(): HasMany
    {
        return $this->hasMany(FixedAssetItem::class, 'fixed_asset_item_category_id', 'id');
    }
}
