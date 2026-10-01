<?php

namespace Modules\MaterialManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Modules\InventoryManagement\Models\MaterialItem;

class MaterialRequestNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_request_note';

    protected $fillable = [
        'requested_date',
        'requested_department_id',
        'requested_by',
        'purpose',
        'material_request_note_status_id',
        'status_changed_by',

        //
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
    public function material_request_note_status_type(): BelongsTo
    {
        return $this->belongsTo(MaterialRequestNoteStatusType::class, 'material_request_note_status_type_id', 'id');
    }

    public function material_item_list(): BelongsToMany
    {
        return $this->belongsToMany(MaterialItem::class, 'material_request_note_item_pivot', 'material_request_note_id', 'material_item_id');
    }
}
