<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Optional: Define relationships
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}