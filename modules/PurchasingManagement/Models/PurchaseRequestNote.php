<?php

namespace Modules\PurchasingManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Modules\EmployeeManagement\Models\Employee;
use Modules\InventoryManagement\Models\MaterialItem;

class PurchaseRequestNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purchase_request_note';

    protected $fillable = [
        'item_type',
        'material_item_id',
        'service_item_description',

        'date',
        'quantity',
        'requested_by_id',
        'requirement',

        //
        'purchase_order_id',
        'purchase_order_item_id',
        'purchase_request_note_status_id',
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function purchase_request_note_status(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequestNoteStatus::class, 'purchase_request_note_status_id', 'id');
    }

    public function purchase_request_note_status_list(): HasMany
    {
        return $this->hasMany(PurchaseRequestNoteStatus::class, 'purchase_request_note_id', 'id');
    }

    public function material_item(): BelongsTo
    {
        return $this->belongsTo(MaterialItem::class, 'material_item_id', 'id');
    }

    // public function purchase_order_item(): HasOne
    // {
    //     return $this->hasOne(PurchaseOrderItem::class, 'purchase_request_note_id', 'id');
    // }

    public function requested_by(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by_id', 'id');
    }
}
