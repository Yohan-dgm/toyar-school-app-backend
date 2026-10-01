<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PurchaseRequestNoteStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_request_note_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function purchase_request_note_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNote::class, 'purchase_request_note_status_type_id', 'id');
    }

    public function purchase_request_note_status_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNoteStatus::class, 'purchase_request_note_status_type_id', 'id');
    }
}
