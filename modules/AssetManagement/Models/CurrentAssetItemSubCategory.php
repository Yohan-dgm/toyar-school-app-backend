<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class CurrentAssetItemSubCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'current_asset_item_sub_category';

    protected $fillable = [
        'current_asset_item_category_id',
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function current_asset_item_category(): BelongsTo
    {
        return $this->belongsTo(CurrentAssetItemCategory::class, 'current_asset_item_category_id', 'id');
    }

    public function current_asset_item_list(): HasMany
    {
        return $this->hasMany(CurrentAssetItem::class, 'current_asset_item_sub_category_id', 'id');
    }
}
