<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\EmployeeManagement\Models\Employee;

class EmployeeLeave extends Model
{
    use HasFactory;

    protected $table = 'employee_leave';

    protected $fillable = [
        'name',
        'employee_id',
        'leave_date',
        'leave_duration',
        'employee_leave_status_type_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

 

    // Optional: Define relationships
    public function LeaveType(): BelongsToMany
    {
        return $this->belongsToMany(LeaveType::class, 'employee_Leave_leave_type_pivot',  'employee_leave_id', 'leave_type_id');
        
    } 

    public function employee_leave_status_type(): BelongsTo
    {
        return $this->belongsTo(EmployeeLeaveStatusType::class, 'employee_leave_status_type_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

}