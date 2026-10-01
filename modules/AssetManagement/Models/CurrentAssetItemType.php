<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class CurrentAssetItemType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'current_asset_item_type';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function current_asset_item_category_list(): HasMany
    {
        return $this->hasMany(CurrentAssetItemCategory::class, 'current_asset_item_type_id', 'id');
    }

    public function current_asset_item_list(): HasMany
    {
        return $this->hasMany(CurrentAssetItem::class, 'current_asset_item_type_id', 'id');
    }
}
