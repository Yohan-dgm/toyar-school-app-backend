<?php

namespace Modules\MaterialManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class MaterialIssueNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'material_issue_note';

    protected $fillable = [

        'material_request_note_id',
        'issued_date',
        'issued_by',
        'received_by_id',
        'received_department_id',
        'quantity',
        'purpose',
        'status_changed_by',
        'material_issue_note_status_id',

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
    public function material_issue_note_status_type(): BelongsTo
    {
        return $this->belongsTo(MaterialIssueNoteStatusType::class, 'material_issue_note_status_type_id', 'id');
    }
}
