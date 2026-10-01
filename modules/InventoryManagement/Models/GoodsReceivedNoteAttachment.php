<?php

namespace Modules\InventoryManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class GoodsReceivedNoteAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'goods_received_note_attachment';

    protected $fillable = [
        'goods_received_note_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function goods_received_note(): BelongsTo
    {
        return $this->belongsTo(GoodsReceivedNote::class, 'goods_received_note_id', 'id');
    }
}
