<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EmployeeManagement\Models\Employee;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designation';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // Optional: Define relationships
    public function employee_list()
    {
        return $this->hasMany(Employee::class, 'designation_id');
    }
}