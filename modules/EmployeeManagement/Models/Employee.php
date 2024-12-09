<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\EmployeeManagement\Models\EmployeeType;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'full_name',
        'employee_type_id',
        'nic_number',
        'epf_number',
        'remaining_annual_leave',
        'remaining_medical_leave',
        'remaining_maternity_leave',
        'created_by',
        'updated_by',
    ];

  
    /**
     * Relationship with Employee Type
     */
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }
}