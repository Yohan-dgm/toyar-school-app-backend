<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 
    public function employee_list(): HasMany
    {
        return $this->hasMany(Employee::class, 'designation_id', 'id');
    }


}