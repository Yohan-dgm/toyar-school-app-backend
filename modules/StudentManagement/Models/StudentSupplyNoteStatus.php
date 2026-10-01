<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class StudentSupplyNoteStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_supply_note_status';

    protected $fillable = [

        'student_supply_note_id',
        'student_supply_note_status_type_id',
        'notes',
        'status_changed_by_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_supply_note(): BelongsTo
    {
        return $this->belongsTo(StudentSupplyNote::class, 'student_supply_note_id', 'id');
    }

    public function student_supply_note_status_type(): BelongsTo
    {
        return $this->belongsTo(StudentSupplyNoteStatusType::class, 'student_supply_note_status_type_id', 'id');
    }
}
