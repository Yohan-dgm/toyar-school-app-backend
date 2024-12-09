<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

 

    // Optional: Define relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}