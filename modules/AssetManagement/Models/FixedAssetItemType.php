<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class FixedAssetItemType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'fixed_asset_item_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function fixed_asset_item_category_list(): HasMany
    {
        return $this->hasMany(FixedAssetItemCategory::class, 'fixed_asset_item_type_id', 'id');
    }

    public function fixed_asset_item_list(): HasMany
    {
        return $this->hasMany(FixedAssetItem::class, 'fixed_asset_item_type_id', 'id');
    }
}
