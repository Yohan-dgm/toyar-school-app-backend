<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceType extends Model
{
    use HasFactory;

    protected $table = 'attendance_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function educator_attendance_list(): HasMany
    {
        return $this->hasMany(EducatorAttendance::class, 'attendance_type_id', 'id');
    }
    public function student_attendance_list(): HasMany
    {
        return $this->hasMany(StudentAttendance::class, 'attendance_type_id', 'id');
    }

    // protected static function newFactory(): AttendanceTypeFactory
    // {
    //     return new AttendanceTypeFactory();
    // }
}
