<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class PurchaseRequestNoteStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_request_note_status';

    protected $fillable = [

        'purchase_request_note_id',
        'purchase_request_note_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function purchase_request_note(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequestNote::class, 'purchase_request_note_id', 'id');
    }

    public function purchase_request_note_status_type(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequestNoteStatusType::class, 'purchase_request_note_status_type_id', 'id');
    }
}
