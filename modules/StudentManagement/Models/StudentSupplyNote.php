<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class StudentSupplyNote extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_supply_note';

    protected $fillable = [
        'date',
        'student_id',
        'student_supply_id',
        'quantity',
        'period_start_date',
        'period_end_date',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'student_supply_note_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_supply_note_status(): BelongsTo
    {
        return $this->belongsTo(StudentSupplyNoteStatus::class, 'student_supply_note_status_id', 'id');
    }

    public function student_supply_note_status_list(): HasMany
    {
        return $this->hasMany(StudentSupplyNoteStatus::class, 'student_supply_note_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function student_supply(): BelongsTo
    {
        return $this->belongsTo(StudentSupply::class, 'student_supply_id', 'id');
    }
}
