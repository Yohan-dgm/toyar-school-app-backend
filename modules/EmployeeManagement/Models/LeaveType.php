<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 

    public function employee_leave_list(): BelongsToMany
    {
        return $this->belongsToMany(EmployeeLeave::class, 'employee_Leave_leave_type_pivot', 'leave_type_id',  'employee_leave_id');
        
    } 

}