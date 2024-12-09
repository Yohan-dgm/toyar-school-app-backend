<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EmployeeManagement\Models\Employee;

class EmployeeType extends Model
{
    use HasFactory;

    protected $table = 'employee_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;
 
    public function employees()
    {
        return $this->hasMany(Employee::class, 'employee_type_id', 'id'); 

    }
}