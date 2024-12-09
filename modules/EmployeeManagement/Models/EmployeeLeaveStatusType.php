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

  
    public function employee_leave_list(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'employee_leave_status_type_id','id');
    }

    
}