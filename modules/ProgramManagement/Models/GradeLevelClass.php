<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GradeLevelClass extends Model
{
    use HasFactory;

    protected $table = 'grade_level_class';

    protected $fillable = [
        'grade_level_id',
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function grade_level(): HasOne
    {
        return $this->hasOne(GradeLevel::class, 'grade_level_id', 'id');
    }

    // protected static function newFactory(): GradeLevelClassFactory
    // {
    //     return new GradeLevelClassFactory();
    // }
}
