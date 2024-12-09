<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = [
        'name',
        'role_group_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;
 

    public function role_group_list(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'Role_role_group_pivot', 'employee_role_pivot',  'role_id', 'employee_id');
        
    }
 
    public function role_group(): BelongsTo
    {
        return $this->belongsTo(RoleGroup::class, 'role_group_id', 'id');
    }
}