<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeLevel extends Model
{
    use HasFactory;

    protected $table = 'grade_level';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function student_list(): HasMany
    {
        return $this->hasMany(Program::class, 'grade_level_id', 'id');
    }

    // protected static function newFactory(): CurriculumTypeFactory
    // {
    //     return new CurriculumTypeFactory();
    // }
}
