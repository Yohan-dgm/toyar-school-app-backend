<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';

    protected $fillable = [
        'created_by',
        'updated_by',
        'student_id',
        'date',
        'time',
        'attendance_type_id',
    ];

    public $timestamps = true;

    // public function student(): BelongsTo
    // {
    //     return $this->belongsTo(Student::class, 'student_id', 'id');
    // }

    public function attendance_type(): BelongsTo
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type_id', 'id');
    }

    // protected static function newFactory(): StudentAttendanceFactory
    // {
    //     return new StudentAttendanceFactory();
    // }
}
