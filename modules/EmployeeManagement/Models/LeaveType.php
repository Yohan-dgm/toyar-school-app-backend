<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EmployeeManagement\Models\EmployeeLeave;

class LeaveType extends Model
{
    protected $table = 'leave_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

     
    // Relationship with Employee Leaves
    public function employee_leave_list(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'leave_type_id');
    }
}