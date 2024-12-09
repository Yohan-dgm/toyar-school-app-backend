<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\OrganizationManagement\Models\CurriculumType;
use Modules\OrganizationManagement\Models\ProgramDurationType;

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
        'program_duration_type_id',
        'program_status_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }
    public function curriculum_type(): BelongsTo
    {
        return $this->belongsTo(CurriculumType::class, 'curriculum_type_id', 'id');
    }
    public function program_duration_type(): BelongsTo
    {
        return $this->belongsTo(ProgramDurationType::class, 'program_duration_type_id', 'id');
    }

    // protected static function newFactory(): ProgramTypeFactory
    // {
    //     return new ProgramTypeFactory();
    // }
}
