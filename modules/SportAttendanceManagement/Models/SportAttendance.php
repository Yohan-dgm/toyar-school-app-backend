<?php

namespace Modules\SportAttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class SportAttendance extends Model
{
    use HasFactory;

    protected $table = 'sport_attendance';

    protected $fillable = [
        'created_by',
        'updated_by',
        'student_id',
        'date',
        'time',
        'attendance_type_id',
        'notes',
        'sport_activity',
        'team_id',
        'coach_id',
    ];

    public $timestamps = true;

    public function attendance_type(): BelongsTo
    {
        return $this->belongsTo(\Modules\AttendanceManagement\Models\AttendanceType::class, 'attendance_type_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id', 'id');
    }

    // protected static function newFactory(): SportAttendanceFactory
    // {
    //     return new SportAttendanceFactory();
    // }
}
