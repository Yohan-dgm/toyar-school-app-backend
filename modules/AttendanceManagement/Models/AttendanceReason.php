<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class AttendanceReason extends Model
{
    use HasFactory;

    protected $table = 'attendance_reasons';

    protected $fillable = [
        'attendance_id',
        'reason',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(StudentAttendance::class, 'attendance_id', 'id');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
