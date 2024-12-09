<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AttendanceManagement\Models\StudentAttendance;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'full_name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function student_attendance_list(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'student_id', 'id');
    }

    // protected static function newFactory(): StudentFactory
    // {
    //     return new StudentFactory();
    // }
}
