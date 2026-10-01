<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class ServicesReceivedNoteAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'services_received_note_attachment';

    protected $fillable = [
        'services_received_note_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function services_received_note(): BelongsTo
    {
        return $this->belongsTo(ServicesReceivedNote::class, 'services_received_note_id', 'id');
    }
}
