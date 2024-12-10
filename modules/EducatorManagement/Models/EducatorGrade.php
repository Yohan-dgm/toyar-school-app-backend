<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // protected static function newFactory(): EducatorGradeFactory
    // {
    //     return new EducatorGradeFactory();
    // }
}
