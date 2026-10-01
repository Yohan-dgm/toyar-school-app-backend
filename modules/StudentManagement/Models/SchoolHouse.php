<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolHouse extends Model
{
    protected $table = 'school_house';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function student_list(): HasMany
    {
        return $this->hasMany(Student::class, 'school_house_id', 'id');
    }
}
