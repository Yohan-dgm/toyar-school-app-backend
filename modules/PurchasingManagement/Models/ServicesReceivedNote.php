<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ServicesReceivedNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'services_received_note';

    protected $fillable = [
        'purchase_order_id',
        'date',
        'reference_number',
        'office_notes',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        //
        'is_services_received_note_complete',
        'services_received_note_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function services_received_note_item_list(): HasMany
    {
        return $this->hasMany(ServicesReceivedNoteItem::class, 'services_received_note_id', 'id');
    }

    public function services_received_note_attachment_list(): HasMany
    {
        return $this->hasMany(ServicesReceivedNoteAttachment::class, 'services_received_note_id', 'id');
    }

    public function services_received_note_status(): BelongsTo
    {
        return $this->belongsTo(ServicesReceivedNoteStatus::class, 'services_received_note_status_id', 'id');
    }
}
