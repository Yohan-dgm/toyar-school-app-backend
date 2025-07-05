<?php

namespace Modules\CalendarManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Program;
use Modules\ProgramManagement\Models\Subject;

class SpecialClass extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'special_class';

    protected $fillable = [
        'title',
        'program_id',
        'subject_id',
        'special_class_date',
        'start_time',
        'end_time',
        'description',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    // factory
    // protected static function newFactory(): EventFactory
    // {
    //     return new EventFactory();
    // }
}
