<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ServicesReceivedNoteStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'services_received_note_status';

    protected $fillable = [
        'services_received_note_id',
        'services_received_note_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function services_received_note_list(): HasMany
    {
        return $this->hasMany(ServicesReceivedNote::class, 'services_received_note_status_type_id', 'id');
    }
}
