<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducatorAttendance extends Model
{
    use HasFactory;

    protected $table = 'educator_attendance';

    protected $fillable = [
        'created_by',
        'updated_by',
        'educator_id',
        'date',
        'time',
        'attendance_type_id',
    ];

    public $timestamps = true;

    // public function educator(): BelongsTo
    // {
    //     return $this->belongsTo(Educator::class, 'educator_id', 'id');
    // }

    public function attendance_type(): BelongsTo
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type_id', 'id');
    }

    // protected static function newFactory(): EducatorAttendanceFactory
    // {
    //     return new EducatorAttendanceFactory();
    // }
}
