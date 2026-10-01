<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class StudentSupplyNoteStatusType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_supply_note_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_supply_note_status_list(): HasMany
    {
        return $this->hasMany(StudentSupplyNoteStatus::class, 'student_supply_note_status_type_id', 'id');
    }
}
