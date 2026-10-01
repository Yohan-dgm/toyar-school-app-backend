<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class FixedAssetItemSubCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'fixed_asset_item_sub_category';

    protected $fillable = [
        'fixed_asset_item_category_id',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function fixed_asset_item_category(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItemCategory::class, 'fixed_asset_item_category_id', 'id');
    }

    public function fixed_asset_item_list(): HasMany
    {
        return $this->hasMany(FixedAssetItem::class, 'fixed_asset_item_sub_category_id', 'id');
    }
}
