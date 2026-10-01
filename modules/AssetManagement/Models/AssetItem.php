<?php

namespace Modules\AssetManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\PurchasingManagement\Models\GoodsReceivedNote;

class AssetItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'asset_item';

    protected $fillable = [
        'asset_type',
        'fixed_asset_item_id',
        'current_asset_item_id',
        'goods_received_note_id',
        'received_date',
        'received_quantity',
        'current_quantity',
        'unit_price',
        'landed_rate',
        'landed_value',
        'is_unusable',

        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function fixed_asset_item(): BelongsTo
    {
        return $this->belongsTo(FixedAssetItem::class, 'fixed_asset_item_id', 'id');
    }

    public function current_asset_item(): BelongsTo
    {
        return $this->belongsTo(CurrentAssetItem::class, 'current_asset_item_id', 'id');
    }

    public function goods_received_note(): BelongsTo
    {
        return $this->belongsTo(GoodsReceivedNote::class, 'goods_received_note_id', 'id');
    }
}
