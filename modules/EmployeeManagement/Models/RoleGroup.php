<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleGroup extends Model
{
    use HasFactory;

    protected $table = 'role_group';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true; 
    
    public function role_list(): HasMany
    {
        return $this->hasMany(Role::class, 'role_group_id', 'id');
    }

}