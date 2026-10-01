<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class GoodsReceivedNoteStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'goods_received_note_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function goods_received_note_list(): HasMany
    {
        return $this->hasMany(GoodsReceivedNote::class, 'goods_received_note_status_type_id', 'id');
    }
}
