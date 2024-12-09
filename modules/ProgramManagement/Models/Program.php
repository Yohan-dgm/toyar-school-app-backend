<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';

    protected $fillable = [
        'name',
        'duration',
        'program_code',
        'program_type_id',
        'curriculum_type_id',
        'grade_level_id',
        'duration_type_id',
        'program_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    // protected static function newFactory(): CurriculumTypeFactory
    // {
    //     return new CurriculumTypeFactory();
    // }
}
