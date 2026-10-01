<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\ProgramManagement\Models\GradeLevelClass;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';

    protected $fillable = [
        'created_by',
        'updated_by',
        'student_id',
        'grade_level_class_id',
        'date',
        'time',
        // 'in_time',
        // 'out_time',
        'attendance_type_id',
        'notes',
    ];

    public $timestamps = true;

    public function attendance_type(): BelongsTo
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function attendance_reason(): HasOne
    {
        return $this->hasOne(AttendanceReason::class, 'attendance_id', 'id');
    }

    // protected static function newFactory(): StudentAttendanceFactory
    // {
    //     return new StudentAttendanceFactory();
    // }
}
