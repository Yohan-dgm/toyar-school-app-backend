<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\OrganizationManagement\Models\SchoolLocation;

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
        'program_status_type_id',
        'created_by',
        'updated_by',
        'sequential_order'
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

    public function subject_list(): HasMany
    {
        return $this->hasMany(Subject::class, 'program_id', 'id');
    }

    public function school_location_list(): BelongsToMany
    {
        return $this->belongsToMany(SchoolLocation::class, 'program_school_location_pivot', 'program_id', 'school_location_id');
    }

    public function program_status_type(): BelongsTo
    {
        return $this->belongsTo(ProgramStatusType::class, 'program_status_type_id', 'id');
    }

    // protected static function newFactory(): ProgramTypeFactory
    // {
    //     return new ProgramTypeFactory();
    // }
}
