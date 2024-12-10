<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EducatorGrade extends Model
{
    use HasFactory;

    protected $table = 'educator_grade';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function educator_list(): HasMany
    {
        return $this->hasMany(Educator::class, 'educator_grade_id', 'id');
    }

    // protected static function newFactory(): EducatorGradeFactory
    // {
    //     return new EducatorGradeFactory();
    // }
}
