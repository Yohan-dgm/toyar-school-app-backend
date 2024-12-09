<?php

namespace Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Optional: Define relationships
    public function roleGroup()
    {
        return $this->belongsTo(RoleGroup::class);
    }
}