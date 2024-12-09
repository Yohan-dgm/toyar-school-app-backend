<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EmployeeManagement\Models\EmployeeLeave;

class EmployeeLeaveStatusType extends Model
{
    protected $table = 'employee_leave_status_type';

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
    public function employee_leave_list(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'leave_status_id');
    }
}