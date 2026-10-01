<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class GoodsReceivedNoteStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'goods_received_note_status';

    protected $fillable = [
        'goods_received_note_id',
        'goods_received_note_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
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
