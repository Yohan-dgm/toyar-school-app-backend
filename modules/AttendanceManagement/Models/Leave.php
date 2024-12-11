<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EmployeeManagement\Models\Employee;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leave';

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_duration_type',
        'leave_date',
        'leave_period_start_date',
        'leave_period_end_date',
        'next_reporting_date',
        'leave_status_type_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function leave_status_type(): BelongsTo
    {
        return $this->belongsTo(LeaveStatusType::class, 'leave_status_type_id', 'id');
    }

    public function leave_type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }
}
