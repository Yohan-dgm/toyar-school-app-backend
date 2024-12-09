<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\Models\Employee;

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
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}