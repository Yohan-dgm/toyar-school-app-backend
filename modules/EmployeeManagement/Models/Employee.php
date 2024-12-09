<?php

namespace Modules\EmployeeManagement\Models;

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
        'remaining_annual_leaves',
        'remaining_medical_leaves',
        'remaining_maternity_leaves',
        'created_by',
        'updated_by',
    ];

  
    /**
     * Relationship with Employee Type
     */
    public function employee_list()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }
}