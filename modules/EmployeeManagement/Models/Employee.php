<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'full_name',
        'employee_type_id',
        'nic_number',
        'epf_number',
        'designation_id', 
        'remaining_annual_leaves',
        'remaining_medical_leaves',
        'remaining_maternity_leaves',
        'created_by',
        'updated_by',
    ];

  
    /**
     * Relationship with Employee Type
     */
    
    public function role_list(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'employee_role_pivot', 'employee_id',  'role_id');
        
    }
 
    public function designation_list(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function employee_leave_list(): HasMany
    {
        return $this->hasMany(EmployeeLeave::class, 'employee_id', 'id');
    }



}