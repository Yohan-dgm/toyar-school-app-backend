<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EmployeeManagement\Models\EmployeeLeave;

class EmployeeLeaveStatus extends Model
{
    protected $table = 'employee_leave_status';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

 
    /**
     * Relationship with Employee Leaves
     * 
     * Note: This assumes an EmployeeLeave model exists
     */
    public function employeeLeaves(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'leave_status_id');
    }
}